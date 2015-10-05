<?php namespace Droit\Newsletter\Entities;

use Droit\Common\BaseModel as BaseModel;

class Newsletter extends BaseModel {

	protected $fillable = ['titre','from_name','from_email','return_email','unsuscribe','preview','logos','header'];

}