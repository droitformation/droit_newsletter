@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">

        <div class="panel panel-green">

            <!-- form start -->
            {{ Form::open(array(
                'method'        => 'POST',
                'data-validate' => 'parsley',
                'files'         => true,
                'class'         => 'validate-form form-horizontal',
                'url'           => array('admin/campagne')))
            }}

                <div class="panel-heading">
                    <h4>Ajouter une campagne</h4>
                </div>
                <div class="panel-body event-info">

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Sujet</label>
                        <div class="col-sm-6">
                            {{ Form::text('sujet', null , array('class' => 'form-control') ) }}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Auteurs</label>
                        <div class="col-sm-6">
                            {{ Form::text('auteurs', null , array('class' => 'form-control') ) }}
                        </div>
                    </div>

                </div>
                <div class="panel-footer mini-footer ">
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
