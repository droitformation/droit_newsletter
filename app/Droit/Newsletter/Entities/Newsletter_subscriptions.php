<?php namespace Droit\Newsletter\Entities;

class Newsletter_subscriptions extends \Eloquent {

	protected $fillable = ['user_id','newsletter_id'];

}