
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
                    <?php $sorted = $arret->arrets_categories->sortBy('parent_id')->groupBy('parent_id'); ?>
                    @foreach($sorted as $parent => $categories)
                        @if(!empty($parent))
                            <?php $desired_parent = $parents->filter(function($item) use ($parent) { return $item->id == $parent; })->first(); ?>

                            @if($desired_parent->image)
                                <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                                    <img width="130" border="0" alt="{{ $desired_parent->title }}" src="{{ asset('newsletter/pictos/'.$desired_parent->image) }}">
                                </a>
                            @else
                                <h3 style=" font-family: Arial,Helvetica,sans-serif;font-style: normal; line-height: 24px; color: #006eb4;font-size: 14px; margin: 10px 0;">{{ $desired_parent->title }}</h3>
                            @endif
                        @endif

                        @foreach($categories as $categorie)
                            <a style="margin-bottom: 10px;" target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                                <img border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
                            </a>
                        @endforeach
                    @endforeach
                @endif
            </div>
        </div>

    @endforeach
@endif


