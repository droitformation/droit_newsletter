@extends('layouts.master')
@section('content')

    <div class="row">

        <div id="inner-content" class="col-md-8 col-xs-12">

            <h2>{{ $campagne->sujet }}</h2>
            <h3>{{ $campagne->auteurs }}</h3>

            <hr/>

            @if(!empty($content))
                @foreach($content as $bloc)
                    {!! view('frontend/content/'.$bloc->type->partial)->with( ['bloc' => $bloc ,'categories' => $categories, 'imgcategories' => $imgcategories ])->__toString()  !!}
                @endforeach
            @endif
        </div>

        <!-- Sidebar  -->
        <div id="sidebar" class="col-md-4 col-xs-12">
            @include('partials.subscribe')
            @include('partials.liste')
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->

@stop
