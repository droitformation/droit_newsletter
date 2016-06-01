<?php
namespace App\Droit\Service;

class MigrateWorker{

    protected $custom;
    protected $client;
    protected $campagne_id;
    protected $data;

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

    public function process($articles)
    {
        $blocs = [];

        if(!$articles->isEmpty())
        {
            foreach($articles as $article) {

                if(isset($article['image']) && !empty($article['image'])) {
                    $blocs[] = ['type' => 'image', 'content' => $article];
                }
                if(isset($article['title']) && !empty($article['title']) && $this->isArret($article['title'])){
                    $blocs[] = ['type' => 'arret', 'content' => $article];
                }
                
                if(isset($article['content']) && !empty($article['content']) && !$this->isArret($article['title'])){
                    $blocs[] = ['type' => 'text', 'content' => $article];
                }
                
            }
        }

        return $blocs;
    }

    public function isArret($title)
    {
        return (!empty($title) && strpos($title, 'TF') !== false ? true : false);
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

    public function makeCampagne()
    {
        return factory(\App\Droit\Newsletter\Entities\Newsletter_campagnes::class)->make([
            'sujet'         => $this->getNewsletterSujet(),
            'auteurs'       => $this->getAuthors(),
            'newsletter_id' => 1,
            'status'        => 'envoyé',
            'created_at'    => $this->getNewsletterDate(),
            'updated_at'    => $this->getNewsletterDate()
        ]);
    }

    public function contentBloc($article)
    {
        $date = $this->getNewsletterDate();

        // Make arret
        if($article['type'] == 5)
        {
            $arret = factory(\App\Droit\Arret\Entities\Arret::class)->create([
                'user_id'    => 1,
                'reference'  => $article['title'],
                'pub_date'   => $date,
                'abstract'   => $article['resume'],
                'pub_text'   => $article['content'],
                'categories' => 0,
                'file'       => null,
                'dumois'     => ($article['rang'] == 1 ? 1 : 0),
                'created_at' => date('Y-m-d G:i:s'),
                'updated_at' => date('Y-m-d G:i:s')
            ]);
        }

        // make newsletter content
        $new = factory(\App\Droit\Newsletter\Entities\Newsletter_contents::class)->create([
            'type_id'                => $article['type'],
            'arret_id'               => isset($arret) ? $arret->id : 0,
            'titre'                  => (isset($article['titre'])  ? $article['titre'] : null),
            'contenu'                => (isset($article['contenu'])? $article['contenu'] : null),
            'image'                  => null,
            'lien'                   => null,
            'rang'                   => $article['rang'],
            'newsletter_campagne_id' => $article['campagne_id'],
            'created_at'             => $date,
            'updated_at'             => $date,
        ]);

    }
    
}