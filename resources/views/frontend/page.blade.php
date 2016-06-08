@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-8 col-xs-12">

        <h1>{{ $page->title }}</h1>

        <hr/>

        {!! $page->content !!}
    </div>

    <!-- Sidebar  -->
    <div class="col-md-4 col-xs-12">

    </div>
    <!-- END Sidebar  -->
</div><!--END CONTENT-->

@stop

