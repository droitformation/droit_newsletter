<?php namespace App\Droit\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model {

	protected $fillable = ['titre','from_name','from_email','return_email','unsuscribe','preview','logos','header'];

}