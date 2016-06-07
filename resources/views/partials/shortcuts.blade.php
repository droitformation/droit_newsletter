@if(!$pages->isEmpty())
    @foreach($pages as $page)
        <div class="col-md-4 bloc-3-col">
            <h4>{{ $page->title }}</h4>
            {!! $page->excerpt !!}
            <a href="{{ url('page/'.$page->id) }}" class="btn btn-primary">En savoir plus</a>
        </div>
    @endforeach
@endif
