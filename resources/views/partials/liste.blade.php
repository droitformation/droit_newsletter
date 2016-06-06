<div class="widget">
    <h3 class="title"><i class="icon-envelope"></i> &nbsp;Archives</h3>
    <ul class="bra_recent_entries">

        @if(!$newsletters->sent->isEmpty())
            <ul class="list-group">
                @foreach($newsletters->sent as $campagne)
                    @if($campagne->status == 'envoyé')
                        <a href="{{ url('newsletter/campagne/'.$campagne->id) }}" class="list-group-item {{ Request::is('newsletter/campagne/'.$campagne->id) ? 'active' : '' }}">{{ $campagne->sujet }}</a>
                    @endif
                @endforeach
            </ul>
        @else
            <p>Encore aucune newsletter</p>
        @endif

    </ul><!--END UL-->
</div><!--END WIDGET-->

<p class="divider-border"></p>
