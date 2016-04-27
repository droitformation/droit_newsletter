<div class="row">
    <div class="col-md-9">
        <div class="post">
            <div class="post-title">
                <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
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
    <div class="col-md-3 listCat">
        @if(!$bloc->arrets_categories->isEmpty() )
        <?php $sorted = $bloc->arrets_categories->sortBy('parent_id')->groupBy('parent_id'); ?>
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
                    <a target="_blank" href="{{ url('jurisprudence') }}#{{ $bloc->reference }}">
                        <img width="130" border="0" alt="{{ $categorie->title }}" src="{{ asset('newsletter/pictos/'.$categorie->image) }}">
                    </a>
                @endforeach
            @endforeach
        @endif
    </div>
</div>

@if(!$bloc->arrets_analyses->isEmpty())

<!-- Bloc content-->
<div class="row">
    <div class="col-md-9">

        @foreach($bloc->arrets_analyses as $analyse)
            <div class="post">
                    <div class="post-title">
                        <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                        <h2 class="title">Analyse de l'arrêt {{ $bloc->reference }}</h2>
                    </div><!--END POST-TITLE-->
                    <div class="post-entry">
                        <h4>{{ $analyse->authors }}</h4>
                        <p>{{ $analyse->abstract }}</p>
                        <p><a target="_blank" href="{{ asset('files/analyses/'.$analyse->file) }}">Télécharger en pdf</a></p>
                    </div>
            </div><!--END POST-->
        @endforeach

    </div>
    <div class="col-md-3 listCat">
        <a href="{{ url('jurisprudence') }}">
            <img width="130" border="0" alt="Analyse" src="{{ asset('images/analyse.png') }}">
        </a>
    </div>
    <!-- Bloc content-->

</div>
@endif
