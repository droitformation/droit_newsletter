<?php namespace App\Droit\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_subscriptions extends Model {

	protected $fillable = ['user_id','newsletter_id'];

}