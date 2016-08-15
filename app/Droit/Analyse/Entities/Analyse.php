<?php namespace App\Droit\Analyse\Entities;

use Illuminate\Database\Eloquent\Model;

class Analyse extends Model {

    protected $table    = 'analyses';
    protected $fillable = ['user_id','authors','pub_date','abstract','file'];
    protected $dates    = ['pub_date','created_at','updated_at'];

    public function getDocumentAttribute()
    {
        return !empty($this->file ) && \File::exists(public_path('files/analyses/'.$this->file)) ? $this->file : null;
    }

    public function getFilterAttribute()
    {
        return $this->categories->map(function ($categorie, $key) {
            return 'c'.$categorie->id;
        })->implode(' ');
    }

    public function categories()
    {
        return $this->belongsToMany('\App\Droit\Categorie\Entities\Categorie', 'analyse_categories', 'analyse_id', 'categories_id')->withPivot('sorting')->orderBy('sorting', 'asc');
    }

    public function arrets()
    {
        return $this->belongsToMany('\App\Droit\Arret\Entities\Arret', 'analyses_arret', 'analyse_id', 'arret_id')->withPivot('sorting')->orderBy('sorting', 'asc');
    }

    public function authors()
    {
        return $this->belongsToMany('\App\Droit\Author\Entities\Author', 'analyse_authors', 'analyse_id', 'author_id')->withPivot('sorting')->orderBy('last_name', 'asc');
    }

}
