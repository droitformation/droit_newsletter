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

        return $this->categorie->where('deleted', '=', 0)->orderBy('title', 'ASC')->get();
    }

    public function getAllOnSite(){
        return $this->categorie->where('deleted', '=', 0)->where('hideOnSite', '=', 0)->orderBy('title', 'ASC')->get();
    }

    public function getAllMain(){

        return $this->categorie->where('ismain','=', 1)->where('deleted', '=', 0)->orderBy('title', 'ASC')->get();
    }

    public function find($id){

        return $this->categorie->with(array('categorie_arrets'))->findOrFail($id);
    }

    public function findyByImage($file){

        return $this->categorie->where('image','=',$file)->where('deleted', '=', 0)->get();
    }

    public function create(array $data){

        $categorie = $this->categorie->create(array(
            'pid'        => $data['pid'],
            'user_id'    => $data['user_id'],
            'title'      => $data['title'],
            'image'      => $data['image'],
            'ismain'     => $data['ismain'],
            'hideOnSite' => $data['hideOnSite'],
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

        $categorie->title      = $data['title'];
        $categorie->ismain     = $data['ismain'];
        $categorie->hideOnSite = $data['hideOnSite'];

        if(!empty($data['image'])){
            $categorie->image = $data['image'];
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
