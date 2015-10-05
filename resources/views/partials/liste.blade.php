<?php $custom = new \Custom; ?>

<div class="widget">
    <h3 class="title"><i class="icon-envelope"></i> &nbsp;Newsletter</h3>
    <ul class="bra_recent_entries">

        @if(!$listCampagnes->isEmpty())
            @foreach($listCampagnes as $campagnes)
                <li>
                    <span class="date">{{ $campagnes->created_at->formatLocalized('%d %B %Y') }}</span>
                    <a href="{{ url('newsletters').'/'.$campagnes->id }}">{{ $campagnes->sujet }}</a>
                    <p>{{ $campagnes->auteurs }}</p>
                </li>
            @endforeach
        @else
        <p>Aucune newsletter pour le moment</p>
        @endif

    </ul><!--END UL-->
</div><!--END WIDGET-->

<p class="divider-border"></p>
