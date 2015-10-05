<?php namespace Droit\Newsletter\Entities;

use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Droit\Common\BaseModel as BaseModel;

class Newsletter_campagnes extends BaseModel {

	protected $fillable = ['sujet','auteurs','newsletter_id'];

    use SoftDeletingTrait;

    protected $dates = ['deleted_at'];

    /*
    * Validation rules
   */
    protected static $rules = array(
        'sujet'   => 'required',
        'auteurs' => 'required'
    );

    /*
     * Validation messages
    */
    protected static $messages = array(
        'sujet.required'   => 'Le sujet est requis',
        'auteurs.required' => 'Le ou les auteur/s est/sont requis'
    );

    public function newsletter(){

        return $this->belongsTo('Droit\Newsletter\Entities\Newsletter', 'newsletter_id', 'id');
    }

}