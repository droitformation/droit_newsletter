
@extends('layouts.master')
@section('content')
	<!-- Header et banner -->
     @include ('partials.banner')
     @include ('partials.shortcuts')
	<!-- END HEADER -->
    
<div class="row">
    <div class="col-md-8">
        <h1>La plateforme RC Assurances</h1>
        <hr class="txt"/>

        @if(!empty($homepage))

            <?php $homepage = $homepage->groupBy('position'); ?>
        
            @foreach($homepage as $type => $contenu)
                <div class="row">
                <!-- Start row -->
                    @foreach($contenu as $bloc)
                        <?php $count = $contenu->count(); ?>
                        <div class="col-md-<?php echo 12/$count; ?>">
                            @if($count == 1)
                                <h4>{{ $bloc->titre }}</h4>
                            @else
                                <h4 <?php echo ( $count > 1 ? 'home-bloc' : ''); ?>>{{ $bloc->titre }}</h4>
                            @endif
                            <p>{!! $bloc->contenu !!}</p>
                        </div>
                    @endforeach
                </div><!-- end row -->

            @endforeach

        @endif

    </div>

    <!-- Sidebar  -->
    <div id="sidebar-right" class="col-md-4 col-xs-12">
        @include('partials.subscribe')
        @include('partials.latest')
    </div>
    <!-- END Sidebar  -->

</div><!--END CONTENT-->

@stop