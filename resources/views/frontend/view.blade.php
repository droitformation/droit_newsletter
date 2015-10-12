@extends('backend.newsletter.layouts.droitravail')
@section('content')

    @if(!empty($content))
        @foreach($content as $bloc)
            <?php  echo View::make('backend/newsletter/send/'.$bloc->type->partial)->with(array('bloc' => $bloc,'categories' => $categories, 'imgcategories' => $imgcategories))->__toString(); ?>
        @endforeach
    @endif

@stop