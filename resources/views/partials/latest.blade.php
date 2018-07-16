<div class="widget">
    <h4>Derniers arrêts commentés</h4>
    <ul class="bra_recent_entries">

        @if(isset($latest) && !$latest->isEmpty())
            @foreach($latest as $last)
                <li>
                    <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                    <span class="date">{{ $last->pub_date->formatLocalized('%d %B %Y') }}</span>
                    <a href="{{ url('jurisprudence').'/#'.$last->reference }}">{{ $last->reference }}</a>
                    <p style="margin-bottom: 0;">{{ $last->abstract }}</p>

                    @foreach($last->analyses as $analyse)
                        <p><a target="_blank" href="{{ asset('files/analyses/'.$analyse->file) }}">Commentaire en pdf</a></p>
                    @endforeach
                </li>
            @endforeach
        @endif

    </ul><!--END UL-->
</div><!--END WIDGET-->

