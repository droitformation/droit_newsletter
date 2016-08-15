<?php namespace App\Droit\Analyse\Repo;

use App\Droit\Analyse\Repo\AnalyseInterface;
use App\Droit\Analyse\Entities\Analyse as M;

class AnalyseEloquent implements AnalyseInterface{

	protected $analyse;

	/**
	 * Construct a new SentryUser Object
	 */
	public function __construct(M $analyse)
	{
		$this->analyse = $analyse;
	}
    
    public function getAll($exclude = []){

        $analyse = $this->analyse->with(['authors','categories','arrets']);

        if(!empty($exclude))
        {
            $analyse->whereNotIn('id', $exclude);
        }

        return $analyse->orderBy('pub_date', 'DESC')->get();
    }

	public function find($id){
				
		return $this->analyse->with(array('authors','categories','arrets'))->find($id);
	}

	public function create(array $data){

		$analyse = $this->analyse->create(array(
			'user_id'    => $data['user_id'],
            'author'     => isset($data['author']) ? $data['author'] : null,
            'pub_date'   => $data['pub_date'],
            'abstract'   => $data['abstract'],
            'file'       => $data['file'],
			'created_at' => date('Y-m-d G:i:s'),
			'updated_at' => date('Y-m-d G:i:s')
		));

		if( ! $analyse )
		{
			return false;
		}

        if(isset($data['categories']))
        {
            // Insert related categories
            $analyse->categories()->sync($data['categories']);
        }

        if(isset($data['arrets']))
        {
            // Insert related arrets
            $analyse->arrets()->sync($data['arrets']);
        }

        if(isset($data['author_id']) && !empty($data['author_id']))
        {
            $analyse->authors()->sync($data['author_id']);
        }
		
		return $analyse;
		
	}
	
	public function update(array $data){

        $analyse = $this->analyse->findOrFail($data['id']);
		
		if( ! $analyse )
		{
			return false;
		}

        $analyse->fill($data);

        if(isset($data['file']))
        {
            $analyse->file = $data['file'];
        }

		$analyse->updated_at = date('Y-m-d G:i:s');

        if(isset($data['categories']))
        {
            // Insert related categories
            $analyse->categories()->sync($data['categories']);
        }

        if(isset($data['arrets']))
        {
            // Insert related arrets
            $analyse->arrets()->sync($data['arrets']);
        }

        if(isset($data['author_id']) && !empty($data['author_id']))
        {
            $analyse->authors()->sync($data['author_id']);
        }

		$analyse->save();
		
		return $analyse;
	}

	public function delete($id){

        $analyse = $this->analyse->find($id);

		return $analyse->delete();
		
	}

}
