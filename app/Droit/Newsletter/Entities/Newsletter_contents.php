<?php namespace Droit\Newsletter\Entities;

use Droit\Common\BaseModel as BaseModel;

class Newsletter_contents extends BaseModel {

	protected $fillable = ['type_id','titre','contenu','image','lien','arret_id','categorie_id','newsletter_campagne_id','rang','groupe_id'];

    /*
     * Validation rules
    */
    protected static $rules = array(
    );

    /*
     * Validation messages
    */
    protected static $messages = array(
    );

    public function campagne(){

        return $this->belongsTo('Droit\Newsletter\Entities\Newsletter_campagnes');
    }

    public function newsletter(){

        return $this->belongsTo('Droit\Newsletter\Entities\Newsletter');
    }

    public function type(){

        return $this->belongsTo('Droit\Newsletter\Entities\Newsletter_types');
    }

    public function arrets(){

        return $this->hasMany('Droit\Content\Entities\Arret', 'id', 'arret_id');
    }

}
