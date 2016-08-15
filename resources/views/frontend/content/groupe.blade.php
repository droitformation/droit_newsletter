
@if(isset($bloc->arrets))

    <div class="row">
        <div class="col-md-9">
            <h3 style="text-align: left;">{{ $categories[$bloc->categorie] }}</h3>
        </div>
        <div class="col-md-3 listCat">
            <img width="130" border="0" src="{{ asset('newsletter/pictos/'.$bloc->image) }}" alt="{{ $categories[$bloc->categorie] }}" />
        </div>
    </div>

    <!-- Bloc content-->
    @foreach($bloc->arrets as $arret)

        <div class="row">
            <div class="col-md-9">
                <div class="post">
                    <div class="post-title">
                        <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                        <h2 class="title">{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
                        <p class="italic">{!! $arret->abstract !!}</p>
                    </div><!--END POST-TITLE-->
                    <div class="post-entry">
                        {!! $arret->pub_text !!}
                    </div>
                </div><!--END POST-->
            </div>
            <div class="col-md-3 listCat">
                @if(!$arret->categories->isEmpty())
                    @foreach($arret->categories as $categorie)
                        <img style="max-width: 140px;" border="0" alt="{{ $categorie->title }}" src="<?php echo asset('files/pictos/'.$categorie->image) ?>">
                    @endforeach
                @endif
            </div>
        </div>

    @endforeach
@endif


