@extends('layouts.admin')
@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="options" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/campagne') }}" class="btn btn-default"><i class="fa fa-list"></i>  &nbsp;&nbsp;Retour aux campagnes</a>
                <a href="{{ url('admin/campagne/'.$infos->id.'/edit') }}" class="btn btn-sky"><i class="fa fa-pencil"></i>  &nbsp;&Eacute;diter la campagne</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        {{ Form::open(array('url' => array('admin/send/test') , 'class' => 'form-inline')) }}
            <div class="form-group">
                <input required name="email" value="" type="email" class="form-control">
                <input name="id" value="{{ $infos->id }}" type="hidden">
            </div>
            <button type="submit" class="btn btn-brown"><i class="fa fa-question-circle"></i>  &nbsp;&nbsp;Envoyer un test</button>
        {{ Form::close() }}
    </div>
</div>

<div id="main" ng-app="newsletter"><!-- main div for app-->

    <div class="row">
        <div class="col-md-12">

            <input id="campagne_id" value="{{ $infos->id }}" type="hidden">

            <div class="component-build"><!-- Start component-build -->
                <div id="bailNewsletter" class="onBuild">

                    <!-- Logos -->
                    @include('newsletter.send.logos')
                    <!-- Header -->
                    @include('newsletter.send.header')

                    <div id="viewBuild">
                        <div id="sortable">
                            @if(!empty($campagne))
                                @foreach($campagne as $bloc)
                                    <div class="bloc_rang" id="bloc_rang_{{ $bloc->idItem }}" data-rel="{{ $bloc->idItem }}">
                                        <?php echo View::make('newsletter/build/edit/'.$bloc->type->partial)->with(array('bloc' => $bloc))->__toString(); ?>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div id="build"><!-- Start build -->

                    @if(!empty($blocs))
                        @foreach($blocs as $bloc)
                            <div class="create_bloc" id="create_{{ $bloc->id }}">
                                <?php echo View::make('newsletter/build/create/'.$bloc->template)->with(array('bloc' => $bloc, 'infos' => $infos))->__toString(); ?>
                            </div>
                        @endforeach
                    @endif

                    <div class="component-menu">
                        <h5>Composants</h5>
                        <a name="componant"></a>
                        <div class="component-bloc">
                            @if(!empty($blocs))
                                @foreach($blocs as $bloc)
                                      <?php echo View::make('newsletter/build/blocs')->with(array('bloc' => $bloc))->__toString(); ?>
                                @endforeach
                            @endif
                        </div>
                    </div><!-- End build -->

                </div>
            </div><!-- End component-build -->

        </div><!-- end 12 col -->
    </div><!-- end row -->

</div><!-- end main div for app-->

@stop