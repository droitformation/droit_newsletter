<?php namespace Droit\Newsletter\Entities;

use Droit\Common\BaseModel as BaseModel;

class Newsletter_styles extends BaseModel {

	protected $fillable = ['styles','newsletter_id','tag_name'];
}