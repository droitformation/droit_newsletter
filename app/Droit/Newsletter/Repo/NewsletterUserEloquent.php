<?php namespace App\Droit\Newsletter\Repo;

use App\Droit\Newsletter\Entities\Newsletter_users as M;
use App\Droit\Newsletter\Repo\NewsletterUserInterface;

class NewsletterUserEloquent implements NewsletterUserInterface{

	protected $user;

	public function __construct(M $user)
	{
		$this->user = $user;
	}
	
	public function getAll()
    {
		return $this->user->with(['subscriptions'])->get();
	}

    public function getAllNbr($nbr)
    {
        return $this->user->with(['subscriptions'])->take(5)->orderBy('id', 'desc')->get();
    }

	public function find($id)
    {
		return $this->user->with(['subscriptions'])->findOrFail($id);
	}

	public function findByEmail($email)
    {
        $user = $this->user->with(['subscriptions'])->where('email','=',$email)->get();

		return !$user->isEmpty() ? $user->first() : null;
	}

    public function get_ajax( $sEcho , $iDisplayStart , $iDisplayLength , $iSortCol_0, $sSortDir_0, $sSearch ){

        $columns = ['id','status','activated_at','email','abo','delete'];

        $iTotal  = $this->user->all()->count();

        if($sSearch)
        {
            $data = $this->user->where('email','LIKE','%'.$sSearch.'%')->with(['subscriptions'])
                ->orderBy($columns[$iSortCol_0], $sSortDir_0)
                ->take($iDisplayLength)
                ->skip($iDisplayStart)
                ->get();

            $iTotalDisplayRecords = $data->count();
        }
        else
        {
            $data = $this->user->with(['subscriptions'])
                                ->orderBy($columns[$iSortCol_0], $sSortDir_0)
                                ->take($iDisplayLength)
                                ->skip($iDisplayStart)
                                ->get();

            $iTotalDisplayRecords = $iTotal;
        }

        $output = array(
            "sEcho"                => $sEcho,
            "iTotalRecords"        => $iTotal,
            "iTotalDisplayRecords" => $iTotalDisplayRecords,
            "aaData"               => []
        );

        foreach($data as $abonne)
        {
            $row = array();

            $row['id']     = '<a class="btn btn-sky btn-sm" href="'.url('admin/subscriber/'.$abonne->id).'">&Eacute;diter</a>';
            $status = ( $abonne->activated_at ? '<span class="label label-success">Confirmé</span>' : ' <span class="label label-default">Email non confirmé</span>');
            $row['status']       = $status;

            setlocale(LC_ALL, 'fr_FR.UTF-8');
            $row['activated_at'] = ( $abonne->activated_at ? $abonne->activated_at->formatLocalized('%d %B %Y') : '' );
            $row['email']        = $abonne->email;

            if( !$abonne->subscriptions->isEmpty() )
            {
                $abos       = $abonne->subscriptions->lists('titre')->all();
                $row['abo'] = implode(',',$abos);
            }
            else
            {
                $row['abo'] = '';
            }

            $row['delete']  = '<form action="'.url('admin/subscriber/'.$abonne->id).'" method="POST">';
            $row['delete'] .= csrf_field();
            $row['delete'] .= '<input type="hidden" name="_method" value="DELETE">';
            $row['delete'] .= '<input type="hidden" name="email" value="'.$abonne->email.'">';
            $row['delete'] .= '<button data-what="supprimer" data-action="Abonné '.$abonne->email.'" class="btn btn-danger btn-xs deleteAction">Supprimer</button>';
            $row['delete'] .= '</form>';

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

		$user = $this->user->create([
            'email'            => $data['email'],
            'activation_token' => (isset($data['activation_token']) ? $data['activation_token'] : null),
            'activated_at'     => (isset($data['activated_at']) ? $data['activated_at'] : null),
            'created_at'       => date('Y-m-d G:i:s'),
            'updated_at'       => date('Y-m-d G:i:s')
        ]);
		
		if( ! $user )
		{
			return false;
		}

		return $user;
	}
	
	public function update(array $data){

        $user = $this->user->findOrFail($data['id']);
		
		if( ! $user )
		{
			return false;
		}

        $user->activated_at = ( isset($data['activated_at'])) ? date('Y-m-d G:i:s') : null;
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
