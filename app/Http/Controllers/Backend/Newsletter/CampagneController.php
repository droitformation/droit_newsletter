<?php

namespace App\Http\Controllers\Backend\Newsletter;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Newsletter\Repo\NewsletterTypesInterface;
use App\Droit\Newsletter\Repo\NewsletterContentInterface;
use App\Droit\Arret\Repo\GroupeInterface;
use App\Droit\Newsletter\Worker\CampagneInterface;
use App\Droit\Newsletter\Worker\MailjetInterface;

class CampagneController extends Controller
{
    protected $campagne;
    protected $content;
    protected $mailjet;
    protected $types;
    protected $groupe;
    protected $worker;
    protected $helper;

    public function __construct(NewsletterCampagneInterface $campagne, NewsletterContentInterface $content, GroupeInterface $groupe, MailjetInterface $mailjet, NewsletterTypesInterface $types, CampagneInterface $worker )
    {
        $this->campagne = $campagne;
        $this->content  = $content;
        $this->types    = $types;
        $this->groupe   = $groupe;
        $this->worker   = $worker;
        $this->mailjet  = $mailjet;
        $this->helper   = new \App\Droit\Helper\Helper();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campagnes = $this->campagne->getAll();

        return view('backend.newsletter.campagne.index')->with(compact('campagnes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.newsletter.campagne.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        echo '<pre>';
        print_r($request->all());
        echo '</pre>';exit;

        $campagne = $this->campagne->create( ['sujet' => $request->input('sujet'), 'auteurs' => $request->input('auteurs'), 'template' => 1] );

        $created  = $this->mailjet->createCampagne($campagne);

        if(!$created)
        {
            throw new \App\Exceptions\CampagneCreationException('Problème avec la création de campagne sur mailjet');
        }

        return redirect('admin/campagne/'.$campagne->id)->with( array('status' => 'success' , 'message' => 'Campagne crée') );

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blocs         = $this->types->getAll();
        $infos         = $this->campagne->find($id);
        $campagne      = $this->worker->prepareCampagne($id);
        $categories    = $this->worker->getCategoriesArrets();
        $imgcategories = $this->worker->getCategoriesImagesArrets();

        return view('backend.newsletter.campagne.show')->with(
            ['isNewsletter' => true, 'campagne' => $campagne , 'infos' => $infos, 'blocs' => $blocs, 'categories' => $categories, 'imgcategories' => $imgcategories]
        );
    }

    /**
     * Send campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function send()
    {
        //
    }

    /**
     * Send test campagne
     *
     * @return \Illuminate\Http\Response
     */
    public function test(Request $request)
    {

        $id    = $request->input('id');
        $email = $request->input('email');

        $campagne = $this->campagne->getCampagne($id);
        $sujet    = ($campagne->status == 'brouillon' ? 'TEST | '.$campagne->sujet : $campagne->sujet );

        // GET html
        $html = $this->campagne->html($campagne->id);

        echo '<pre>';
        print_r($html);
        echo '</pre>';exit;

        $this->worker->sendTest($email,$html,$sujet);

        $ajax = $request->input('send_type', 'normal');

        if($ajax == 'ajax'){
            echo 'ok';
            exit;
        }

        return redirect('admin/campagne/'.$id)->with( array('status' => 'success' , 'message' => 'Email de test envoyé!' ) );
    }


    /**
     * Add bloc to newsletter
     * POST data
     * @return Response
     */
    public function process(Request $request){

        $data = $request->all();

        $data['categorie_id']           = (isset($data['categorie_id']) ? $data['categorie_id'] : 0);
        $data['newsletter_campagne_id'] = $data['campagne'];

        if($data['type_id'] == 7)
        {
            $arrets = $this->helper->prepareCategories($data['arrets']);
            $groupe = $this->groupe->create(array('categorie_id' => $data['categorie_id']));
            $groupe->arrets_groupes()->sync($arrets);

            $data['groupe_id'] = $groupe->id;
        }

        // image resize
        if(isset($data['image']) && !empty($data['image']))
        {
            $this->helper->resizeImage($data['image'],$data['type_id']);
        }

        $this->content->create($data);

        return redirect()->to('admin/campagne/'.$data['campagne'].'#componant')->with(array('status' => 'success', 'message' => 'Bloc ajouté' ));

    }

    /**
     * Edit bloc from newsletter
     * POST data
     * @return Response
     */
    public function editContent(Request $request){

        $data = $request->all();

        $new  = array('id' => $data['id']);

        if(!empty($data))
        {
            foreach($data as $key => $input)
            {
                if(!empty($input)){
                    $new[$key] = $input;
                }
            }
        }

        $contents = $this->content->update($new);

        if($contents)
        {
            return redirect()->back()->with(array('status' => 'success', 'message' => 'Bloc édité' ));
        }

        return redirect()->back()->with(array('status' => 'error', 'message' => 'Problème avec l\'édition' ));

    }

    /**
     * Sorting bloc newsletter
     * POST remove
     * AJAX
     * @return Response
     */
    public function sorting(Request $request){

        $data = $request->all();

        $contents = $this->content->updateSorting($data['bloc_rang']);

        print_r($data);

    }

    /**
     * Sorting bloc newsletter
     * POST remove
     * AJAX
     * @return Response
     */
    public function sortingGroup(Request $request){

        $data = $request->all();

        $groupe_rang = $data['groupe_rang'];
        $groupe_id   = $data['groupe_id'];

        $arrets = $this->helper->prepareCategories($groupe_rang);

        $groupe = $this->groupe->find($groupe_id);
        $groupe->arrets_groupes()->sync($arrets);

        print_r($groupe);

    }


    /**
     * Remove bloc from newsletter
     * POST remove
     * AJAX
     * @return Response
     */
    public function remove(Request $request){

        $this->content->delete($request->input('id'));

        return 'ok';
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
