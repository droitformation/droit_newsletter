@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-8 col-xs-12">
        <h1 class="title uppercase">Auteurs et contributeurs</h1>

        <hr/>

        @if(!$auteurs->isEmpty())
            @foreach($auteurs as $auteur)
            <div class="media">
                <div class="media-left">
                    <img width="100" class="media-object" src="{{ asset('authors/'.$auteur->author_photo) }}" alt="{{ $auteur->name }}">
                </div>
                <div class="media-body bio-body">
                    <h3 class="media-heading">{{ $auteur->name }}</h3>
                    <h5>{{ $auteur->occupation }}</h5>
                    <div class="bio_auteur">{!! $auteur->bio !!}</div>

                    <!-- Analyses from author -->
                    @if(!$auteur->analyses->isEmpty())
                        <h5><strong>{{ ($auteur->analyses->count() > 1 ? 'Analyses des arrêts' : 'Analyse de l\'arrêt') }}:</strong></h5>
                        <ul class="analyse_auteur">
                            @foreach($auteur->analyses as $analyse)
                                <?php $analyse->load('arrets'); ?>
                                @if(isset($analyse->arrets) && $analyse->arrets->count() > 0)
                                    <li>
                                        <p>
                                            <a href="{{ url('jurisprudence#analyse_'.$analyse->id) }}">
                                                {{ $analyse->arrets->first()->reference }}</a>
                                            <i>{{ $analyse->remarque }}</i>
                                        </p>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                </div>
            </div>
            @endforeach
        @endif

    </div><!--END CONTENT-->
    <!-- Sidebar  -->
    <div id="sidebar-right" class="col-md-4 col-xs-12">
        @include('partials.subscribe')
        @include('partials.latest')
    </div>
    <!-- END Sidebar  -->
</div>

@stop

