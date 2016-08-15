<?php namespace App\Droit\Arret\Worker;

use App\Droit\Analyse\Repo\AnalyseInterface;

class JurisprudenceWorker{

    protected $analyse;
    protected $newsworker;

    /* Inject dependencies */
    public function __construct(AnalyseInterface $analyse)
    {
        $this->analyse    = $analyse;
        $this->newsworker = \App::make('newsworker');

        setlocale(LC_ALL, 'fr_FR.UTF-8');
    }

    /**
     * Return collection analyses exclude not sent
     *
     * @return collection
     */
    public function filter($site_id)
    {
        $newsletters = $this->newsworker->siteNewsletters($site_id);
        $exclude     = $this->newsworker->arretsToHide($newsletters->lists('id')->all());

        $analyses = $this->analyse->getAll($site_id,$exclude);
        $analyses = $analyses->lists('analyse_id');

        return (isset($analyses) ? $analyses : []);
    }
}