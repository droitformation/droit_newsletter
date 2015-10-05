<?php namespace Droit\Newsletter\Repo;

interface NewsletterUserInterface {

	public function getAll();
    public function getAllNbr($nbr);
	public function find($id);
	public function findByEmail($email);
    public function get_ajax( $sEcho , $iDisplayStart , $iDisplayLength , $iSortCol_0, $sSortDir_0, $sSearch );
    public function activate($token);
	public function create(array $data);
	public function update(array $data);
    public function add(array $data);
	public function delete($id);

}
