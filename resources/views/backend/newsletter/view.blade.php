@extends('newsletter.layouts.droitravail')
@section('content')

    @if(!empty($content))
        @foreach($content as $bloc)
            <?php  echo View::make('newsletter/send/'.$bloc->type->partial)->with(array('bloc' => $bloc))->__toString(); ?>
        @endforeach
    @endif

@stop