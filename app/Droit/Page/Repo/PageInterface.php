<?php namespace App\Droit\Page\Repo;

interface PageInterface {

    public function getAll();
    public function getRoot();
    public function getTree($key = null, $seperator = '  ');
    public function find($id);
    public function search($term);
    public function buildTree($data);
    public function getBySlug($site);
    public function create(array $data);
    public function update(array $data);
    public function updateSorting(array $data);
    public function delete($id);

}
