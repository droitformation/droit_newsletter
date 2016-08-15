@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="page-header text-align-left">
                <h1 class="title uppercase">Newsletter</h1>
                <h2 class="subtitle">Archives</h2>
            </div><!--END PAGE-HEADER-->
        </div>
    </div>

    <div class="row">
        <div id="inner-content" class="col-md-8 col-xs-12">
            @if(isset($newsletters) && !$newsletters->campagnes->isEmpty())
                <?php
                    $archives = $newsletters->campagnes->groupBy(function ($archive, $key) {
                        return $archive->created_at->year;
                    });
                ?>

                @foreach($archives as $year => $campagnes)
                    <dl class="dl-horizontal">
                    <dt><strong><i class="fa fa-calendar" aria-hidden="true"></i> &nbsp;Année {{ $year }}</strong></dt>
                        @foreach($campagnes as $campagne)
                            <dd>
                                <h5><a href="{{ url('newsletter/campagne/'.$campagne->id )}}">{{ $campagne->sujet }}</a></h5>
                            </dd>
                        @endforeach
                    </dl>
                @endforeach
            @endif
        </div>

        <!-- Sidebar  -->
        <div id="sidebar" class="col-md-4 col-xs-12">
            @include('partials.subscribe')
            @include('partials.pub')
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->

@stop
