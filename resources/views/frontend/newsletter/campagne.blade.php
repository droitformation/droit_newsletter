@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="page-header text-align-left">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title uppercase">{{ $campagne->sujet }}</h1>
                        <h2 class="subtitle">{{ $campagne->auteurs }}</h2>
                    </div>
                </div>
            </div><!--END PAGE-HEADER-->
        </div>
    </div>


    <div class="row">
        <div id="inner-content" class="col-md-8 col-xs-12">
            @if(!$campagne->content->isEmpty())
                @foreach($campagne->content as $bloc)
                    <div class="bloc-newsletter">
                        {!! view('newsletter::Frontend.content.'.$bloc->type->partial)->with(['bloc' => $bloc ])->__toString() !!}
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Sidebar  -->
        <div id="sidebar" class="col-md-4 col-xs-12">
            @include('partials.liste')
            @include('partials.pub')
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->

@stop
