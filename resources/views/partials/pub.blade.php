@if(isset($sidebar['pub']) && !$sidebar['pub']->isEmpty())

    <div class="widget">
        <h3 class="title"><i class="glyphicon glyphicon-pushpin"></i> &nbsp;New</h3>

        @foreach($sidebar['pub'] as $ad)

            @if( !empty($ad->titre) && !empty($ad->url) && !empty($ad->image))
                <div class="media">
                    <a class="media-left" target="_blank" href="{{ $ad->url }}">
                        <img style="max-width: 130px;" src="{{ url('files').'/'.$ad->image }}" alt="{{{ $ad->titre or 'image' }}}" />
                    </a>
                    <div class="media-body">
                        <h4 class="media-heading">{{ $ad->titre }}</h4>
                        {!! $ad->contenu or '' !!}
                        <a class="btn btn-default btn-xs" target="_blank" href="{{ $ad->url }}">En savoir plus</a>
                    </div>
                </div>
            @elseif(!empty($ad->url) && !empty($ad->image))
                <div class="media">
                    <a class="pub-image-simple" target="_blank" href="{{ $ad->url }}">
                        <img style="max-width:100%;" src="{{ url('files').'/'.$ad->image }}" alt="{{{ $ad->titre or 'image' }}}" />
                    </a>
                </div>
            @elseif(!empty($ad->image))
                <div class="media">
                    <img src="{{ url('files').'/'.$ad->image }}" alt="{{{ $ad->titre or 'image' }}}" />
                </div>
            @endif

        @endforeach

    </div><!--END WIDGET-->

@endif