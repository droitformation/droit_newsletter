@extends('backend.layouts.master')
@section('content')

<div class="row">
    <div class="col-md-4">
        <div class="options" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
                <a href="{{ url('admin/newsletter') }}" class="btn btn-default"><i class="fa fa-list"></i>  &nbsp;&nbsp;Retour aux campagnes</a>
                <a href="{{ url('admin/campagne/'.$infos->id.'/edit') }}" class="btn btn-sky"><i class="fa fa-pencil"></i>  &nbsp;&Eacute;diter la campagne</a>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <form action="{{ url('admin/campagne/test') }}" enctype="multipart/form-data" method="POST" class="form-inline">
            {!! csrf_field() !!}
            <div class="form-group">
                <input required name="email" value="" type="email" class="form-control">
                <input name="id" value="{{ $infos->id }}" type="hidden">
            </div>
            <button type="submit" class="btn btn-brown"><i class="fa fa-question-circle"></i>  &nbsp;&nbsp;Envoyer un test</button>
        </form>
    </div>
</div>

<div id="main" ng-app="newsletter"><!-- main div for app-->

    <style type="text/css">

        #StyleNewsletter h2, #StyleNewsletterCreate h2{
            color: {{ $infos->newsletter->color }};
        }

        #StyleNewsletter .contentForm h3, #StyleNewsletter .contentForm h4{
            color: {{ $infos->newsletter->color }};
        }

    </style>

    <div class="row">
        <div class="col-md-12">

            <input id="campagne_id" value="{{ $infos->id }}" type="hidden">

            <div class="component-build"><!-- Start component-build -->
                <div id="StyleNewsletter" class="onBuild">

                    <!-- Logos -->
                    @include('backend.newsletter.send.logos')
                    <!-- Header -->
                    @include('backend.newsletter.send.header')

                    <div id="viewBuild">
                        <div id="sortable">
                            @if(!empty($campagne))
                                @foreach($campagne as $bloc)
                                    <div class="bloc_rang" id="bloc_rang_{{ $bloc->idItem }}" data-rel="{{ $bloc->idItem }}">
                                        <?php echo view('backend.newsletter/build/edit/'.$bloc->type->partial)->with(array('bloc' => $bloc, 'categories' => $categories, 'imgcategories' => $imgcategories))->__toString(); ?>
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
                                <?php echo view('backend/newsletter/build/create/'.$bloc->template)->with(array('bloc' => $bloc, 'infos' => $infos, 'categories' => $categories, 'imgcategories' => $imgcategories))->__toString(); ?>
                            </div>
                        @endforeach
                    @endif

                    <div class="component-menu">
                        <h5>Composants</h5>
                        <a name="componant"></a>
                        <div class="component-bloc">
                            @if(!empty($blocs))
                                @foreach($blocs as $bloc)
                                      <?php echo view('backend/newsletter/build/blocs')->with(array('bloc' => $bloc))->__toString(); ?>
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