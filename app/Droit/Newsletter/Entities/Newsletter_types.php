<?php namespace App\Droit\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_types extends Model {

	protected $fillable = ['titre','partial','elements'];
}