<div class="container">	
    <div class="row">
        @if(!$pages->isEmpty())
            @foreach($pages as $page)
                <div class="bloc">
                    <div class="shortnav-bloc">
                        <h4>{{ $page->title }}</h4>
                        {!! $page->excerpt !!}
                        <a href="{{ url('page/'.$page->id) }}" class="btn btn-primary">En savoir plus</a>
                    </div>
                </div>
            @endforeach
        @endif
	</div>
 </div>     
    