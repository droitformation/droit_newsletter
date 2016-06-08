@if(!$bloc->arrets_analyses->isEmpty())

    <!-- Bloc content-->
    <div class="row">
        <div class="col-md-9">

            @foreach($bloc->arrets_analyses as $analyse)
                <div class="post">
                    <div class="post-title">
                        <h2 class="title">Analyse de l'arrêt {{ $bloc->reference }}</h2>
                    </div><!--END POST-TITLE-->
                    <div class="post-entry">
                        @if(!$analyse->analyse_authors->isEmpty())
                            @foreach($analyse->analyse_authors as $analyse_authors)
                                <img style="width: 60px;float: left; margin: 0 10px 15px 0;" width="60" border="0" alt="{{ $analyse_authors->name }}" src="{{ asset('authors/'.$analyse_authors->photo) }}">
                                <h3>{{ $analyse_authors->name }}</h3>
                                <p>{{  $analyse_authors->occupation }}</p>
                            @endforeach
                        @endif
                        <p>{{ $analyse->abstract }}</p>
                        <p><a target="_blank" href="{{ asset('files/analyses/'.$analyse->file) }}">Télécharger en pdf</a></p>
                    </div>
                </div><!--END POST-->
            @endforeach

        </div>
        <div class="col-md-3 listCat">
            <a href="{{ url('jurisprudence') }}">
                <img border="0" alt="Analyses" src="<?php echo asset('newsletter/pictos/analyse.png') ?>">
            </a>
        </div>
        <!-- Bloc content-->

    </div>
@endif

<div class="row">
    <div class="col-md-{{ $bloc->arrets_categories->isEmpty() ? '12' : 9 }}">
        <div class="post">
            <div class="post-title">
                <h2 class="title">{{ $bloc->reference }} du {{ $bloc->pub_date->formatLocalized('%d %B %Y') }}</h2>
                <p>{!! $bloc->abstract !!}</p>
            </div><!--END POST-TITLE-->
            <div class="post-entry">
                {!! $bloc->pub_text !!}
                @if(isset($bloc->file))
                    <p><a target="_blank" href="{{ asset('files/arrets/'.$bloc->file) }}">Télécharger en pdf</a></p>
                @endif
            </div>
        </div><!--END POST-->
    </div>
    @if(!$bloc->arrets_categories->isEmpty() )
        <div class="col-md-3 listCat">
            @foreach($bloc->arrets_categories as $categorie)
                <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                    <img border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
                </a>
            @endforeach
        </div>
    @endif
</div>

