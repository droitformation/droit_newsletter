@extends('layouts.master')
@section('content')

<?php $custom = new \App\Droit\Helper\Helper(); ?>

<div class="row">
    <div id="filteringApp" ng-app="filtering">
		<div class="col-md-12">
        <h1>Jurisprudence</h1>

        <hr/>
		</div>
        <div class="col-md-8 col-xs-12">
            <div id="filtering">
                <div class="arrets">

                    @include('frontend.content.analyse')

                    @if(!empty($arrets))

                        <h4 class="title-section-top"><i class="fa fa-university"></i> &nbsp;&nbsp;Jurisprudence</h4>

                        @foreach($arrets as $post)
                            @include('frontend.content.post')
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

        <!-- Sidebar  -->
        <div class="col-md-4 col-xs-12">
            <div class="fixed">
                @include('partials.filter')
            </div>
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->
</div><!--END CONTENT-->

@stop
