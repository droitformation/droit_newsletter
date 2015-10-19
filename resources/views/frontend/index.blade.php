
@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-8">
        <h1>Content Homepage</h1>
        <hr/>

        @if(!empty($homepage))

            <?php $homepage = $homepage->groupBy('position'); ?>
        
            @foreach($homepage as $type => $contenu)
                <div class="row"><!-- Start row -->
                    @foreach($contenu as $bloc)
                        <?php $count = $contenu->count(); ?>
                        <div class="col-md-<?php echo 12/$count; ?>">
                            @if($count == 1)
                                <h3 class="title">{{ $bloc->titre }}</h3>
                            @else
                                <h4 class="title <?php echo ( $count > 1 ? 'home-bloc' : ''); ?>">{{ $bloc->titre }}</h4>
                            @endif
                            <p>{!! $bloc->contenu !!}</p>
                        </div>
                    @endforeach
                </div><!-- end row -->

            @endforeach

        @endif

    </div>

    <!-- Sidebar  -->
    <div class="col-md-4 col-xs-12">
        @include('partials.subscribe')
        @include('partials.soutien')
        @include('partials.pub')
        @include('partials.sidebar')
    </div>
    <!-- END Sidebar  -->

</div><!--END CONTENT-->

@stop