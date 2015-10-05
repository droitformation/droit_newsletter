<?php namespace App\Droit\Categorie\Entities;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model {

	protected $fillable = ['pid','user_id','deleted','title','image','ismain','hideOnSite'];
    protected $dates    = ['created_at','updated_at'];

    public function categorie_arrets()
    {
        return $this->belongsToMany('\App\Droit\Arret\Entities\Arret', 'arret_categories', 'categories_id', 'arret_id');
    }
}