@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="options text-right" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
               <a href="{{ url('admin/parent/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter</a>
            </div>
        </div>

        <div class="panel panel-midnightblue">
            <div class="panel-heading">
                <h4><i class="fa fa-tasks"></i> &nbsp;Catégories parente</h4>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table" style="margin-bottom: 0px;" id="generic">
                        <thead>
                        <tr>
                            <th class="col-sm-2">Action</th>
                            <th class="col-sm-4">Titre</th>
                            <th class="col-sm-2 no-sort"></th>
                        </tr>
                        </thead>
                        <tbody class="selects">

                            @if(!$parents->isEmpty())
                                @foreach($parents as $parent)
                                    <tr>
                                        <td><a class="btn btn-sky btn-sm" href="{{ url('admin/parent/'.$parent->id) }}">&Eacute;diter</a></td>
                                        <td><strong>{{ $parent->title }}</strong></td>
                                        <td class="text-right">
                                            {!! Form::open(['route' => array('admin.parent.destroy', $parent->id), 'method' => 'delete']) !!}
                                                <button data-id="{{ $parent->id }}" class="btn btn-danger btn-sm deleteParent">Supprimer</button>
                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@stop