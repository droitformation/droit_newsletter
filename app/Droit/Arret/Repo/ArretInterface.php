<?php namespace App\Droit\Arret\Repo;

interface ArretInterface {

    public function getAll($nbr = null);
    public function getAllActives($exclude = []);
    public function getPaginate($nbr);
    public function getLatest($exclude = []);
	public function find($data);
    public function annees();
    public function findyByImage($file);
	public function create(array $data);
	public function update(array $data);
	public function delete($id);

}
