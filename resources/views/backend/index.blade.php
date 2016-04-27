@extends('backend.layouts.master')
@section('content')

    <div class="row">

        <div class="col-md-6">
            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4><i class="fa fa-edit"></i> &nbsp;Derniers arrêts</h4>
                </div>
                <div class="panel-body">
                    <table class="table" style="margin-bottom: 0px;" id="">
                        <thead>
                        <tr>
                            <th class="col-sm-2">Action</th>
                            <th class="col-sm-4">Référence</th>
                            <th class="col-sm-4">Date de publication</th>
                            <th class="col-sm-2 no-sort"></th>
                        </tr>
                        </thead>
                        <tbody class="selects">
                            @if(!$arrets->isEmpty())
                                @foreach($arrets as $arret)
                                    <tr>
                                        <td><a class="btn btn-sky btn-sm" href="{{ url('admin/arret/'.$arret->id) }}">éditer</a></td>
                                        <td><strong>{{ $arret->reference }}</strong></td>
                                        <td>{{ $arret->pub_date->formatLocalized('%d %B %Y') }}</td>
                                        <td class="text-right">
                                            {!! Form::open(array('route' => array('admin.arret.destroy', $arret->id), 'method' => 'delete')) !!}
                                            <button data-what="supprimer" data-action="arrêt {{ $arret->reference }}" class="btn btn-danger btn-sm deleteAction"><i class="fa fa-times"></i></button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <br/>
                    <p><a class="btn btn-sm btn-primary" href="#">Tous</a></p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-midnightblue">
                <div class="panel-heading">
                    <h4><i class="fa fa-edit"></i> &nbsp;Contenus page d'accueil</h4>
                </div>
                <div class="panel-body">
                    <table class="table" style="margin-bottom: 0px;" id="">
                        <thead>
                        <tr>
                            <th class="col-sm-2">Action</th>
                            <th class="col-sm-4">Titre</th>
                            <th class="col-sm-4">Position</th>
                            <th class="col-sm-2"></th>
                        </tr>
                        </thead>
                        <tbody class="selects">
                        @if(!$contents->isEmpty())
                            @foreach($contents as $content)
                                <tr>
                                    <td><a class="btn btn-sky btn-sm" href="{{ url('admin/contenu/'.$content->id) }}">&Eacute;diter</a></td>
                                    <td><strong>{{ $content->titre or '' }}</strong></td>
                                    <td>{{ $positions[$content->position] }}</td>
                                    <td class="text-right">
                                        {!! Form::open(array('route' => array('admin.contenu.destroy', $content->id), 'method' => 'delete')) !!}
                                            <button data-what="supprimer" data-action="contenu: {{ $content->titre }}" class="btn btn-danger btn-sm deleteAction"><i class="fa fa-times"></i></button>
                                        {!! Form::close() !!}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                    <br/>
                    <p><a class="btn btn-sm btn-primary" href="#">Tous</a></p>
                </div>
            </div>
        </div>

    </div>

@stop