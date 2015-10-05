<?php namespace Droit\Newsletter\Entities;

use Droit\Common\BaseModel as BaseModel;

class Newsletter_types extends BaseModel {

	protected $fillable = ['titre','partial','elements'];
}