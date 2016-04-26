@extends('backend.layouts.master')
@section('content')

<div class="row"><!-- row -->
    <div class="col-md-12"><!-- col -->
        <p class="pull-left"><a class="btn btn-default" href="{{ url('admin/page') }}"><i class="fa fa-reply"></i> &nbsp;Retour à la liste</a></p>
        <p class="pull-right"><a href="{{ url('admin/page/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter une page</a></p>
    </div>
</div>

<!-- start row -->
<div class="row">

    @if (!empty($page) )

    <div class="col-md-12">
        <div class="panel panel-midnightblue">

            <!-- form start -->
            <form data-validate-parsley action="{{ url('admin/page/'.$page->id) }}" method="POST" class="form-horizontal" >
                <input type="hidden" name="_method" value="PUT">
                {!! csrf_field() !!}

                <div class="panel-heading">
                    <h4>&Eacute;diter {{ $page->titre }}</h4>
                </div>
                <div class="panel-body event-info">

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Ordre</label>
                        <div class="col-sm-2">
                            {!! Form::text('rang', $page->rang , array('class' => 'form-control') ) !!}
                        </div>
                        <div class="col-sm-4">
                            <p class="help-block">Ordre croissant</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Visible sur le site</label>
                        <div class="col-sm-5">
                            <label class="radio-inline"><input type="radio" value="0" {{ !$page->hidden ? 'checked' : '' }} name="hidden"> Oui</label>
                            <label class="radio-inline"><input type="radio" value="1" {{ $page->hidden ? 'checked' : '' }} name="hidden"> Non</label>
                        </div>
                    </div>

                    <hr/>

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Titre</label>
                        <div class="col-sm-7">
                            {!! Form::text('title', $page->title , array('class' => 'form-control') ) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contenu" class="col-sm-3 control-label">Extrait</label>
                        <div class="col-sm-7">
                            {!! Form::textarea('excerpt', $page->excerpt , array('class' => 'form-control  redactorSimple' )) !!}
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="contenu" class="col-sm-3 control-label">Contenu</label>
                        <div class="col-sm-7">
                            {!! Form::textarea('content', $page->content , array('class' => 'form-control  redactor' )) !!}
                        </div>
                    </div>

                </div>
                <div class="panel-footer mini-footer ">
                    {!! Form::hidden('id', $page->id ) !!}
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="submit">Envoyer </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @endif

</div>
<!-- end row -->

@stop