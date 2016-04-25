<?php namespace  App\Droit\Categorie\Repo;

use  App\Droit\Categorie\Repo\ParentInterface;
use  App\Droit\Categorie\Entities\Parent_categorie as M;

class ParentEloquent implements ParentInterface{

    protected $parent;

    public function __construct(M $parent)
    {
        $this->parent = $parent;
    }

    public function getAll()
    {
        return $this->parent->orderBy('title', 'ASC')->get();
    }

    public function find($id)
    {
        return $this->parent->find($id);
    }

    public function create(array $data){

        $parent = $this->parent->create(array(
            'title'  => $data['title'],
            'image'  => isset($data['image']) ? $data['image'] : ''
        ));

        if( ! $parent )
        {
            return false;
        }

        return $parent;
    }

    public function update(array $data){

        $parent = $this->parent->findOrFail($data['id']);

        if( ! $parent )
        {
            return false;
        }

        $parent->fill($data);
        $parent->save();

        return $parent;
    }

    public function delete($id){

        $parent = $this->parent->find($id);

        return $parent->delete();
    }
}
