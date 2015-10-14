@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-6">
        <h3>Liste des newsletter</h3>
    </div>
    <div class="col-md-6">
        <div class="options text-right" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/newsletter/create') }}" class="btn btn-green"><i class="fa fa-plus"></i> &nbsp;Nouvelle newsletter</a>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">

        @if(!empty($newsletters))
            @foreach($newsletters as $newsletter)

                <div class="panel panel-info">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-7">
                                <h3>{{ $newsletter->titre }}</h3>
                                <small><a class="text-danger" href="{{ url('admin/newsletter/'.$newsletter->id) }}">supprimer</a></small>
                            </div>
                            <div class="col-md-3">
                                <p><i class="fa fa-user"></i> &nbsp; {{ $newsletter->from_name }}</p>
                                <p><i class="fa fa-envelope"></i> &nbsp; {{ $newsletter->from_email }}</p>
                            </div>
                            <div class="col-md-2 text-right">
                                <div class="btn-group-vertical" role="group">
                                    <a href="{{ url('admin/newsletter/'.$newsletter->id) }}" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> &nbsp;éditer</a>
                                    <a href="{{ url('admin/campagne/create/'.$newsletter->id) }}" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> &nbsp;campagne</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                @if(!$newsletter->campagnes->isEmpty())
                                    <table class="table table-striped">
                                       <thead>
                                           <tr>
                                               <th class="col-md-3">Sujet</th>
                                               <th class="col-md-3">Auteurs</th>
                                               <th class="col-md-1">Status</th>
                                               <th class="col-md-2"></th>
                                               <th class="col-md-2"></th>
                                               <th class="col-md-1"></th>
                                           </tr>
                                       </thead>
                                       <tbody>
                                            @foreach($newsletter->campagnes as $campagne)
                                                <tr>
                                                    <td><strong><a href="{{ url('admin/campagne/'.$campagne->id.'/edit') }}">{{ $campagne->sujet }}</a></strong></td>
                                                    <td>{{ $campagne->auteurs }}</td>
                                                    <td>
                                                        @if($campagne->status == 'brouillon')
                                                            <span class="label label-default">Brouillon</span>
                                                        @else
                                                            <span class="label label-success">Envoyé</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($campagne->status == 'brouillon')
                                                            <a class="btn btn-inverse btn-sm" href="{{ url('admin/campagne/'.$campagne->id) }}">Composer</a>
                                                        @else
                                                            <div class="btn-group">
                                                                <a class="btn btn-primary btn-sm" href="{{ url('admin/statistics/'.$campagne->id) }}">Stats</a>
                                                                <a href="javascript:;" class="btn btn-default btn-sm sendEmailNewsletter" data-campagne="{{ $campagne->id }}">Envoyer par email</a>
                                                            </div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($campagne->status == 'brouillon')
                                                            <form action="{{ url('admin/campagne/send') }}" id="sendCampagneForm" method="POST">
                                                                {!! csrf_field() !!}
                                                                <input name="id" value="{{ $campagne->id }}" type="hidden">
                                                                <a href="javascript:;" data-campagne="{{ $campagne->id }}" class="btn btn-sm btn-warning btn-block" id="bootbox-demo-3">
                                                                    <i class="fa fa-exclamation"></i> &nbsp;Envoyer la campagne
                                                                </a>
                                                            </form>
                                                        @else
                                                            <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                                                           Envoyé le {{ $campagne->updated_at->formatLocalized('%d %b %Y') }} à {{ $campagne->updated_at->toTimeString() }}
                                                        @endif
                                                    </td>
                                                    <td class="text-right">
                                                        <form action="{{ url('admin/campagne/'.$campagne->id) }}" method="POST">
                                                            <input type="hidden" name="_method" value="DELETE">{!! csrf_field() !!}
                                                            <button data-action="campagne {{ $campagne->sujet }}" class="btn btn-danger btn-sm deleteAction"><i class="fa fa-remove"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                       </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>

            @endforeach
        @endif

    </div>
</div>

@stop
