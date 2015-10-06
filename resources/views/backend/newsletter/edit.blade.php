@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <div class="options" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/campagne') }}" class="btn btn-inverse"><i class="fa fa-chevron-left"></i> &nbsp;Retour aux campagnes</a>
                <a href="{{ url('admin/campagne/'.$campagne->id) }}" class="btn btn-inverse pull-right"> Composer newsletter  &nbsp;<i class="fa fa-chevron-right"></i></a>
            </div>
        </div>

        <div class="panel panel-sky">

            <!-- form start -->
            {{ Form::model($campagne ,array(
                'method'        => 'PUT',
                'id'            => 'campagne',
                'data-validate' => 'parsley',
                'class'         => 'validate-form form-horizontal',
                'url'           => array('admin/campagne/'.$campagne->id)))
            }}

                <div class="panel-heading">
                    <h4>&Eacute;diter une campagne</h4>
                </div>
                <div class="panel-body event-info">

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Sujet</label>
                        <div class="col-sm-6">
                            {{ Form::text('sujet', $campagne->sujet , array('class' => 'form-control') ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Auteurs</label>
                        <div class="col-sm-6">
                            {{ Form::text('auteurs', $campagne->auteurs , array('class' => 'form-control') ) }}
                        </div>
                    </div>

                </div>
                <div class="panel-footer mini-footer ">
                    {{ Form::hidden('user_id', 1 )}}
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </div>
                </div>

            {{ Form::close() }}

        </div>

    </div>
</div>

@stop
