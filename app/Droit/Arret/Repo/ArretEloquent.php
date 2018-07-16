<?php namespace App\Droit\Arret\Repo;

use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Arret\Entities\Arret as M;

class ArretEloquent implements ArretInterface{

	protected $arret;

	public function __construct(M $arret)
	{
		$this->arret = $arret;
	}

    public function getAll($nbr = null)
    {
        $arrets = $this->arret->with(['categories','analyses'])->orderBy('reference', 'ASC');

        if($nbr){
            $arrets->take(5);
        }

        return $arrets->get();
    }

    public function getAllActives($exclude = []){

        $arrets = $this->arret->with(['categories','analyses']);

        if(!empty($exclude)){
            $arrets->whereNotIn('id', $exclude);
        }

        return $arrets->orderBy('pub_date', 'DESC')->get();

    }

    public function getPaginate($nbr)
    {
        return $this->arret->with( array('categories','analyses'))->orderBy('pub_date', 'DESC')->paginate($nbr);
    }

    public function getLatest($exclude = [])
    {
        return $this->arret->whereNotIn('id', $exclude)->has('analyses')->with(['analyses'])->orderBy('id', 'DESC')->get()->take(5);
    }

	public function find($id){

        if(is_array($id))
        {
            return $this->arret->whereIn('id', $id)->with(['categories','analyses'])->get();
        }

		return $this->arret->with(['categories','analyses'])->find($id);
	}

    public function findyByImage($file){

        return $this->arret->where('file','=',$file)->get();
    }

    public function annees()
    {
        $arrets = $this->arret->all();

        return $arrets->groupBy(function ($archive, $key) {
            return $archive->pub_date->year;
        })->keys()->sort()->reverse();
    }

	public function create(array $data){

		$arret = $this->arret->create(array(
			'user_id'    => $data['user_id'],
            'reference'  => $data['reference'],
            'pub_date'   => $data['pub_date'],
            'abstract'   => $data['abstract'],
            'pub_text'   => $data['pub_text'],
            'file'       => isset($data['file']) ? $data['file'] : '',
            'dumois'     => (isset($data['dumois']) && $data['dumois'] == 1 ? 1 : 0),
			'created_at' => date('Y-m-d G:i:s'),
			'updated_at' => date('Y-m-d G:i:s')
		));

		if( ! $arret )
		{
			return false;
		}

        // Insert related categories
        if(isset($data['categories']))
        {
            $arret->categories()->sync($data['categories']);
        }

		return $arret;
		
	}
	
	public function update(array $data){

        $arret = $this->arret->findOrFail($data['id']);
		
		if( ! $arret )
		{
			return false;
		}

        $arret->fill($data);

        if(isset($data['file']))
        {
            $arret->file = $data['file'];
        }

        // Insert related categories
        if(isset($data['categories']))
        {
            // Insert related categories
            $arret->categories()->sync($data['categories']);
        }

		$arret->updated_at = date('Y-m-d G:i:s');

		$arret->save();
		
		return $arret;
	}

	public function delete($id){

        $arret = $this->arret->find($id);

		return $arret->delete();
	}

}
