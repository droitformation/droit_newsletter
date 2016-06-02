<?php
namespace App\Droit\Service;

class MigrateWorker{

    protected $custom;
    protected $client;
    protected $campagne_id;
    protected $data;
    protected $articles;

    /* Inject dependencies */
    public function __construct()
    {
        $this->client   = new \GuzzleHttp\Client();
        $this->base_url = 'http://www.droitpourlepraticien.ch/wp-endpoint.php';
    }

    public function setCampagne($campagne_id)
    {
        $this->campagne_id = $campagne_id;

        return $this;
    }

    public function getall()
    {
        $response   = $this->client->get($this->base_url.'?all=1');
        $all = $response->json();

        $collection = new \Illuminate\Support\Collection($all);

        return $collection->flatten();
    }

    public function getData()
    {
        $response   = $this->client->get( $this->base_url.'?api='.$this->campagne_id);
        $this->data = $response->json();

        return $this;
    }

    public function getNewsletter()
    {
        return new \Illuminate\Support\Collection($this->data['data']);
    }

    public function getNewsletterDate()
    {
        $date = \Carbon\Carbon::createFromTimestamp($this->data ['date']);

        return $date->toDateTimeString();
    }

    public function getNewsletterSujet()
    {
        return $this->data['sujet'];
    }
    
    public function getAuthors()
    {
        $arrets =  $this->getNewsletter();
        $header  = $arrets->splice(0,3);

        $authors = $header->pull(1);

        // Clean strings and tags
        $author = preg_replace('/\sclass=[\'|"][^\'"]+[\'|"]/', '', $authors['content']);
        $author = explode('<p>', $author);
        $author = array_values(array_filter($author));

        return strip_tags($author[0]);
    }
    
    /*
     * Prepare articles
     * */
    public function prepare($articles)
    {
        $blocs = [];
        
        if(!$articles->isEmpty())
        {
            foreach($articles as $article) {

                if(isset($article['image']) && isset($article['image']) && !isset($article['content'])) {
                    $blocs[] = ['type' => 'image', 'content' => $article];
                }

                if(isset($article['title']) && isset($article['title']) && $this->isArret($article['title'])){
                    $blocs[] = ['type' => 'arret', 'content' => $article];
                }
                
                if(isset($article['content']) && isset($article['content']) && (!isset($article['title']) || isset($article['title']) && !$this->isArret($article['title']))){
                    $blocs[] = ['type' => 'text', 'content' => $article];
                }
                
            }
        }

        return $blocs;
    }

    public function process()
    {
        // make comapgne
        $campagne = $this->makeCampagne();

        // Get newsletter contents
        $articles = $this->getNewsletter();
        $articles = $articles->slice(3); // remove banner, authors and call to subscribe

        // Prepare and make newsletter contents
        if(!empty($articles))
        {
            $articles = $this->prepare($articles);
            
            foreach($articles as $index => $article)
            {
                $this->contentBloc($article, $campagne, $index);
            }
        }
    }

    public function makeCampagne()
    {
        return factory(\App\Droit\Newsletter\Entities\Newsletter_campagnes::class)->create([
            'sujet'         => $this->getNewsletterSujet(),
            'auteurs'       => $this->getAuthors(),
            'newsletter_id' => 3,
            'status'        => 'envoyé',
            'created_at'    => $this->getNewsletterDate(),
            'updated_at'    => $this->getNewsletterDate()
        ]);
    }

    public function contentBloc($article, $campagne, $index)
    {
        $date = $this->getNewsletterDate();

        $type = $this->blocType($article);

        // Make arret
        if($type == 5)
        {
           $arret = $this->makeArret($article);
        }

        $article = $article['content'];

        // make newsletter content
        $new = factory(\App\Droit\Newsletter\Entities\Newsletter_contents::class)->create([
            'type_id'                => $type,
            'arret_id'               => isset($arret) ? $arret->id : 0,
            'titre'                  => (isset($article['title'])  ? $article['title'] : null),
            'contenu'                => (isset($article['content'])? $article['content'] : null),
            'image'                  => (isset($article['image'])? $article['image'] : null),
            'lien'                   => null,
            'rang'                   => $index,
            'newsletter_campagne_id' => $campagne->id,
            'created_at'             => $date,
            'updated_at'             => $date,
        ]);

    }

    public function makeArret($article)
    {
        $article = $article['content'];

        return factory(\App\Droit\Arret\Entities\Arret::class)->create([
            'user_id'    => 1,
            'reference'  => isset($article['title']) ? $article['title'] : '',
            'pub_date'   => $this->getNewsletterDate(),
            'abstract'   => isset($article['resume']) ? $article['resume'] : '',
            'pub_text'   => isset($article['content']) ? $article['content'] : '',
            'categories' => 0,
            'file'       => null,
            'dumois'     => 0,
            'created_at' => date('Y-m-d G:i:s'),
            'updated_at' => date('Y-m-d G:i:s')
        ]);
    }

    public function isArret($title)
    {
        return (!empty($title) && ( (strpos($title, 'TF') !== false) || (strpos($title, 'TAF') !== false) ) ? true : false);
    }

    public function blocType($article)
    {
        if($article['type'] == 'text')
        {
            if(isset($article['content']['image']) && isset($article['content']['content'])){
                return 2;
            }

            if(!isset($article['content']['image']) && isset($article['content']['content'])){
                return 6;
            }
        }

        if($article['type'] == 'image')
        {
            return 1;
        }

        if($article['type'] == 'arret')
        {
            return 5;
        }
    }

}