<?php namespace App\Droit\Newsletter\Repo;

use App\Droit\Newsletter\Repo\NewsletterContentInterface;
use App\Droit\Newsletter\Entities\Newsletter_contents as M;

class NewsletterContentEloquent implements NewsletterContentInterface{

	protected $contents;
    protected $upload;
    protected $helper;

	/**
	 * Construct a new SentryUser Object
	 */
	public function __construct(M $contents)
	{
		$this->contents = $contents;
        $this->upload   = new \App\Droit\Service\UploadWorker();
        $this->helper   = new \App\Droit\Helper\Helper();
	}
	
	public function getByCampagne($newsletter_campagne_id){
		
		return $this->contents->where('newsletter_campagne_id','=',$newsletter_campagne_id)
                              ->with(array('type','arrets'))
                              ->orderBy('newsletter_contents.rang','ASC')->get();
	}

    public function getArretsByCampagne($brouillon){

        return $this->contents->where('newsletter_campagne_id','=',$brouillon)->get();
    }

    public function getRang($newsletter_campagne_id){

        $rang = $this->contents->where('newsletter_campagne_id','=',$newsletter_campagne_id)->max('rang');

        return ($rang ? $rang : 0);
    }

	public function find($id){
				
		return $this->contents->where('id','=',$id)->with(array('campagne','newsletter'))->get()->first();
	}

    public function findyByImage($file){

        return $this->contents->where('image','=',$file)->get();
    }

    public function updateSorting(array $data){

        if(!empty($data))
        {
            foreach($data as $rang => $id)
            {
                $contents = $this->find($id);

                if( ! $contents )
                {
                    return false;
                }

                $contents->rang = $rang;
                $contents->save();
            }

            return true;
        }
    }

	public function create(array $data){

		$contents = $this->contents->create(array(
			'type_id'                => $data['type_id'],
			'titre'                  => (isset($data['titre']) ? $data['titre'] : null),
            'contenu'                => (isset($data['contenu']) ? $data['contenu'] : null),
            'image'                  => (isset($data['image']) ? $data['image'] : null),
            'lien'                   => (isset($data['lien']) ? $this->helper->sanitizeUrl($data['lien']) : null),
            'arret_id'               => (isset($data['arret_id']) ? $data['arret_id'] : 0),
            'categorie_id'           => $data['categorie_id'],
            'groupe_id'              => (isset($data['groupe_id']) ? $data['groupe_id'] : null),
            'newsletter_campagne_id' => $data['newsletter_campagne_id'],
            'rang'                   => $this->getRang($data['campagne']),
			'created_at'             => date('Y-m-d G:i:s'),
			'updated_at'             => date('Y-m-d G:i:s')
		));
		
		if( ! $contents )
		{
            throw new \App\Exceptions\ContentCreationException('Creation of new content failed');
		}
		
		return $contents;
		
	}
	
	public function update(array $data){

        $contents = $this->contents->findOrFail($data['id']);
		
		if( ! $contents )
		{
			return false;
		}

        // if there is a content
        if(isset($data['titre'])) {
            $contents->titre = $data['titre'];
        }
        // if there is a content
        if(isset($data['contenu'])) {
            $contents->contenu = $data['contenu'];
        }
        // if we changed the image
        if(isset($data['image'])){

            $type = $contents->type_id;
            $this->helper->resizeImage($data['image'],$type);

            $contents->image = $data['image'];
        }
        // if we changed the lien
        if(isset($data['lien']))
        {
            $contents->lien = $this->helper->sanitizeUrl($data['lien']);
        }
        // if we changed the group
        if(isset($data['groupe_id']))
        {
            $contents->groupe_id = $data['groupe_id'];
        }

        $contents->updated_at = date('Y-m-d G:i:s');
		$contents->save();
		
		return $contents;
	}

	public function delete($id){

        $contents = $this->contents->find($id);

		return $contents->delete();
		
	}

					
}
