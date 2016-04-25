<?php namespace App\Droit\Categorie\Entities;

use Illuminate\Database\Eloquent\Model;

class Parent_categorie extends Model {

	protected $fillable = ['title'];
    public $timestamps  = false;
    protected $table    = 'parent_categories';
}