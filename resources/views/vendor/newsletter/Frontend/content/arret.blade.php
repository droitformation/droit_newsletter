@if(!$bloc->arret->analyses->isEmpty())

    <!-- Bloc content-->
    <div class="row">
        <div class="col-md-9">

            @foreach($bloc->arret->analyses as $analyse)
                <div class="post">
                    <div class="post-title">
                        <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                        <h2 class="title">Analyse de l'arrêt {{ $bloc->arret->reference }}</h2>
                    </div><!--END POST-TITLE-->
                    <div class="post-entry">
                        @if(!$analyse->authors->isEmpty())
                            @foreach($analyse->authors as $author)
                                <div class="row">
                                    <div class="col-md-3">
                                        <img style="width: 60px;" width="60" border="0" alt="{{ $author->name }}" src="{{ asset(config('newsletter.path.author').$author->author_photo) }}">
                                    </div>
                                    <div class="col-md-9">
                                        <h3 style="text-align: left;font-family: sans-serif; color:#000; font-size: 13px; font-weight: bold;">{{ $author->name }}</h3>
                                        <p style="font-family: sans-serif;">{{  $author->occupation }}</p>
                                    </div>
                                </div>
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
                <img width="130" border="0" alt="Analyse" src="{{ asset('files/pictos/analyse.png') }}">
            </a>
        </div>
        <!-- Bloc content-->

    </div>
@endif

<div class="row">
    <div class="col-md-9">
        <h2>{{ $bloc->arret->reference }} du {{ $bloc->arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
        <p>{!! $bloc->arret->abstract !!}</p>

        {!! $bloc->arret->pub_text !!}
        @if(isset($bloc->arret->file))
            <p><a target="_blank" href="{{ asset(config('newsletter.path.arret').$bloc->arret->file) }}">Télécharger en pdf</a></p>
        @endif
    </div>
    <div class="col-md-3">
        @if(!$bloc->arret->categories->isEmpty() )
            @foreach($bloc->arret->categories as $categorie)
                <a target="_blank" href="{{ url(config('newsletter.link.arret')) }}#{{ $bloc->reference }}">
                    <img style="max-width: 130px;" border="0"  alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                </a>
            @endforeach
        @endif
    </div>
</div>

