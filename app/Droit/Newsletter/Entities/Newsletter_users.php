<?php namespace App\Droit\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;

class Newsletter_users extends Model {

    protected $dates    = ['activated_at'];
	protected $fillable = ['email','activation_token','activated_at'];

    public function getActivatedAtAttribute($timestamp)
    {
        return ( ! starts_with($timestamp, '0000')) ? $this->asDateTime($timestamp) : false;
    }

    public function subscription(){

        return $this->hasMany('App\Droit\Newsletter\Entities\Newsletter_subscriptions', 'user_id', 'id');
    }

    public function newsletter(){

        return $this->belongsToMany('App\Droit\Newsletter\Entities\Newsletter', 'newsletter_subscriptions', 'user_id', 'newsletter_id')->withTimestamps();
    }

}