<?php namespace Droit\Newsletter\Worker;

interface CampagneInterface {

	public function findCampagneById($id);
    public function getCategoriesArrets();
    public function getCampagne($id);
    public function html($id);

}
