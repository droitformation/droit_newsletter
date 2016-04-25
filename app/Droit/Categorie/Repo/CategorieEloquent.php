<?php namespace  App\Droit\Categorie\Repo;

use  App\Droit\Categorie\Repo\CategorieInterface;
use  App\Droit\Categorie\Entities\Categorie as M;

class CategorieEloquent implements CategorieInterface{

    protected $categorie;

    public function __construct(M $categorie)
    {
        $this->categorie = $categorie;
    }

    public function getAll(){

        return $this->categorie->with(['parent'])->orderBy('parent_id')->orderBy('title', 'ASC')->get();
    }

    public function getAllOnSite(){
        return $this->categorie->where('hideOnSite', '=', 0)->orderBy('title', 'ASC')->get();
    }

    public function getAllMain(){

        return $this->categorie->where('ismain','=', 1)->orderBy('title', 'ASC')->get();
    }

    public function find($id){

        return $this->categorie->with(['categorie_arrets','parent'])->findOrFail($id);
    }

    public function findyByImage($file){

        return $this->categorie->where('image','=',$file)->get();
    }

    public function create(array $data){

        $categorie = $this->categorie->create(array(
            'title'      => $data['title'],
            'image'      => $data['image'],
            'ismain'     => (isset($data['ismain']) && $data['ismain'] == 1 ? 1 : 0),
            'hideOnSite' => (isset($data['hideOnSite']) && $data['hideOnSite'] == 1 ? 1 : 0),
            'parent_id'  => (isset($data['parent_id']) && !empty($data['parent_id']) ? $data['parent_id'] : null),
            'created_at' => date('Y-m-d G:i:s'),
            'updated_at' => date('Y-m-d G:i:s')
        ));

        if( ! $categorie )
        {
            return false;
        }

        return $categorie;

    }

    public function update(array $data){

        $categorie = $this->categorie->findOrFail($data['id']);

        if( ! $categorie )
        {
            return false;
        }

        $categorie->fill($data);

        if(!empty($data['image']))
        {
            $categorie->image = $data['image'];
        }

        if(isset($data['parent_id']))
        {
            $categorie->parent_id = (isset($data['parent_id']) && !empty($data['parent_id']) ? $data['parent_id'] : null);
        }

        $categorie->updated_at = date('Y-m-d G:i:s');
        $categorie->save();

        return $categorie;
    }

    public function delete($id){

        $categorie = $this->categorie->find($id);

        return $categorie->delete();
    }

}
