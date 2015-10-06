@extends('newsletter.layouts.master')
@section('content')

@if(!empty($content))

    <?php
        echo '<pre>';
        print_r($content);
        echo '</pre>';
     ?>

@endif

@stop