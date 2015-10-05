<?php namespace Droit\Newsletter\Repo;

use Droit\Newsletter\Entities\Newsletter_users as M;
use Droit\Newsletter\Repo\NewsletterUserInterface;
use Droit\Event\UserWasSubscribed;

class NewsletterUserEloquent implements NewsletterUserInterface{

	protected $user;

	/**
	 * Construct a new SentryUser Object
	 */
	public function __construct(M $user)
	{
		$this->user = $user;
	}
	
	public function getAll(){
		
		return $this->user->with(array('subscription' => function($query)
        {
            $query->join('newsletters', 'newsletters.id', '=', 'newsletter_subscriptions.newsletter_id');
        }))->get();
	}

    public function getAllNbr($nbr){
        return $this->user->with(array('subscription' => function($query)
            {
                $query->join('newsletters', 'newsletters.id', '=', 'newsletter_subscriptions.newsletter_id');
            }))->take(5)->orderBy('id', 'desc')->get();
    }

	public function find($id){
				
		return $this->user->with(array('newsletter','subscription' => function($query)
        {
            $query->join('newsletters', 'newsletters.id', '=', 'newsletter_subscriptions.newsletter_id');
        }))->findOrFail($id);
	}

	public function findByEmail($email){

		return $this->user->with(array('newsletter','subscription' => function($query)
		{
			$query->join('newsletters', 'newsletters.id', '=', 'newsletter_subscriptions.newsletter_id');
		}))->where('email','=',$email)->get()->first();
	}

    public function get_ajax( $sEcho , $iDisplayStart , $iDisplayLength , $iSortCol_0, $sSortDir_0, $sSearch ){

        $columns = array('id','status','activated_at','email','abo','delete');

        $iTotal  = $this->user->get(array('id'))->count();

        if($sSearch)
        {
            $data = $this->user->where('email','LIKE','%'.$sSearch.'%')->with(array('subscription' => function($query)
            {
                    $query->join('newsletters', 'newsletters.id', '=', 'newsletter_subscriptions.newsletter_id');

            }))->orderBy($columns[$iSortCol_0], $sSortDir_0)->take($iDisplayLength)->skip($iDisplayStart)->get();

            $iTotalDisplayRecords = $data->count();
        }
        else
        {
            $data = $this->user->with(array('subscription' => function($query)
                {
                    $query->join('newsletters', 'newsletters.id', '=', 'newsletter_subscriptions.newsletter_id');

                }))->orderBy($columns[$iSortCol_0], $sSortDir_0)->take($iDisplayLength)->skip($iDisplayStart)->get();

            $iTotalDisplayRecords = $iTotal;
        }

        $output = array(
            "sEcho"                => $sEcho,
            "iTotalRecords"        => $iTotal,
            "iTotalDisplayRecords" => $iTotalDisplayRecords,
            "aaData"               => array()
        );

        foreach($data as $abonne)
        {
            $row = array();

            $row['id']     = '<a class="btn btn-sky btn-sm" href="'.url('admin/abonne/'.$abonne->id.'/edit').'">&Eacute;diter</a>';
            $status = ( $abonne->activated_at ? '<span class="label label-success">Confirmé</span>' : ' <span class="label label-default">Email non confirmé</span>');
            $row['status']       = $status;

            setlocale(LC_ALL, 'fr_FR.UTF-8');
            $row['activated_at'] = ( $abonne->activated_at ? $abonne->activated_at->formatLocalized('%d %B %Y') : '' );
            $row['email']        = $abonne->email;

            if( !$abonne->subscription->isEmpty() )
            {
                $abos = $abonne->subscription->lists('titre');
                $row['abo'] = implode(',',$abos);
            }

            $row['delete']  = \Form::open(array('route' => array('admin.abonne.destroy', $abonne->email), 'method' => 'delete'));
            $row['delete'] .= '<button data-action="Abonné '.$abonne->email.'" class="btn btn-danger btn-xs deleteAction">Supprimer</button>';
            $row['delete'] .= \Form::close();

            $row = array_values($row);

            $output['aaData'][] = $row;
        }

        return json_encode( $output );

    }

	public function activate($token){

        $user = $this->user->where('activation_token','=',$token)->get()->first();

        if( ! $user )
        {
            return false;
        }

        $user->activated_at = date('Y-m-d G:i:s');
        $user->save();

        return $user;

    }

	public function create(array $data){

		$user = $this->user->create(array(
			'email'            => $data['email'],
            'activation_token' => $data['activation_token'],
			'created_at'       => date('Y-m-d G:i:s'),
			'updated_at'       => date('Y-m-d G:i:s')
		));
		
		if( ! $user )
		{
			return false;
		}

        $user->raise(new UserWasSubscribed($user));

		return $user;
		
	}
	
	public function update(array $data){

        $user = $this->user->findOrFail($data['id']);
		
		if( ! $user )
		{
			return false;
		}

        $user->activated_at = ( $data['activated_at'] > 0 ? date('Y-m-d G:i:s') : '0000-00-00 00:00:00');
        $user->email        = $data['email'];
		$user->updated_at   = date('Y-m-d G:i:s');

		$user->save();
		
		return $user;
	}

    public function add(array $data){

        $user = $this->user->create(array(
            'email'            => $data['email'],
            'activated_at'     => date('Y-m-d G:i:s'),
            'created_at'       => date('Y-m-d G:i:s'),
            'updated_at'       => date('Y-m-d G:i:s')
        ));

        if( ! $user )
        {
            return false;
        }

        return $user;
    }

	public function delete($email){

		return $this->user->where('email', '=', $email)->delete();
		
	}

}
