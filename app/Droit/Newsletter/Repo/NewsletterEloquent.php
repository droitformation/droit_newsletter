<?php namespace Droit\Newsletter\Repo;

use Droit\Newsletter\Repo\NewsletterInterface;
use Droit\Newsletter\Entities\Newsletter as M;

class NewsletterEloquent implements NewsletterInterface{

	protected $newsletter;

	public function __construct(M $newsletter)
	{
		$this->newsletter = $newsletter;
	}
	
	public function getAll(){
		
		return $this->newsletter->orderBy('id','DESC')->get();
	}

	public function find($id){
				
		return $this->newsletter->findOrFail($id);
	}

	public function create(array $data){

		$newsletter = $this->newsletter->create(array(
			'titre'        => $data['titre'],
			'from_name'    => $data['from_name'],
            'from_email'   => $data['from_email'],
            'return_email' => $data['return_email'],
            'unsuscribe'   => $data['unsuscribe'],
            'preview'      => $data['preview'],
            'logos'        => $data['logos'],
            'header'       => $data['header'],
			'created_at'   => date('Y-m-d G:i:s'),
			'updated_at'   => date('Y-m-d G:i:s')
		));
		
		if( ! $newsletter )
		{
			return false;
		}
		
		return $newsletter;
		
	}
	
	public function update(array $data){

        $newsletter = $this->newsletter->findOrFail($data['id']);
		
		if( ! $newsletter )
		{
			return false;
		}

        $newsletter->titre        = $data['titre'];
		$newsletter->from_name    = $data['from_name'];
        $newsletter->from_email   = $data['from_email'];
        $newsletter->return_email = $data['return_email'];
        $newsletter->unsuscribe   = $data['unsuscribe'];
        $newsletter->preview      = $data['preview'];
        $newsletter->logos        = $data['logos'];
        $newsletter->header       = $data['header'];
		$newsletter->updated_at   = date('Y-m-d G:i:s');

		$newsletter->save();
		
		return $newsletter;
	}

	public function delete($id){

        $newsletter = $this->newsletter->find($id);

		return $newsletter->delete();
		
	}
}
