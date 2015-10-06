@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="options" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/subscriber') }}" class="btn btn-inverse"><i class="fa fa-chevron-left"></i> &nbsp;Retour aux abonnés</a>
            </div>
        </div>
        <div class="panel panel-green">

            <form action="{{ url('admin/subscriber') }}" enctype="multipart/form-data" data-validate="parsley" method="POST" class="validate-form form-horizontal">
                {!! csrf_field() !!}

                <div class="panel-heading">
                    <h4>Ajouter un abonné</h4>
                </div>
                <div class="panel-body event-info">

                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">email</label>
                        <div class="col-sm-6">
                            {!! Form::text('email', null , array('class' => 'form-control') ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-6">
                            {!! Form::select('activation', array('1' => 'Confirmé', '0' => 'Non confirmé'), 1 , array('class' => 'form-control')) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Abonnements</label>
                        <div class="col-sm-6">
                            @if(!$newsletter->isEmpty())
                                @foreach($newsletter as $subscriberment)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="newsletter_id[]" value="{{ $subscriberment->id }}">{!! $subscriberment->titre !!}
                                    </label>
                                </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="panel-footer mini-footer ">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="submit">Envoyer</button>
                    </div>
                </div>

            </form>

        </div>

    </div>
</div>

@stop
