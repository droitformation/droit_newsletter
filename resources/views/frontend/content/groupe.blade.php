
@if(isset($bloc->arrets))

    @if(isset($categories[$bloc->categorie]))
        <div class="row">
            <div class="col-md-9">
                <h3 style="text-align: left;">{{ $categories[$bloc->categorie] }}</h3>
            </div>
            <div class="col-md-3 listCat">
                <img width="130" border="0" src="{{ asset('newsletter/pictos/'.$bloc->image) }}" alt="{{ $categories[$bloc->categorie] }}" />
            </div>
        </div>
    @endif
    <!-- Bloc content-->
    @foreach($bloc->arrets as $arret)

        <div class="row">
            <div class="col-md-9">
                <div class="post">
                    <div class="post-title">
                        <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                        <h2 class="title">{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
                        <p>{!! $arret->abstract !!}</p>
                    </div><!--END POST-TITLE-->
                    <div class="post-entry">
                        {!! $arret->pub_text !!}
                    </div>
                </div><!--END POST-->
            </div>
            <div class="col-md-3 listCat">
                @if(!$arret->arrets_categories->isEmpty() )
                    @foreach($arret->arrets_categories as $categorie)
                        <a style="margin-bottom: 15px; display: block;" target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                            <img border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

    @endforeach
@endif


