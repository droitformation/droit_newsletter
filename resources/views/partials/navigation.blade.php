<nav class="navbar">
    <ul class="nav navbar-nav">
        <li><a class="{{ Request::is( '/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a></li>
        <li><a class="{{ Request::is( 'jurisprudence') ? 'active' : '' }}" href="{{ url('jurisprudence') }}">Jurisprudence</a></li>

        @if(isset($newsletters) && !$newsletters->isEmpty())
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Newsletters <span class="caret"></span></a>
            <ul class="dropdown-menu">
                @foreach($newsletters as $newsletter)
                    <li><a href="{{ url('newsletter/'.$newsletter->id) }}">{{ $newsletter->titre }}</a></li>
                @endforeach
            </ul>
        </li>
        @endif

        <li><a class="{{ Request::is( 'auteur') ? 'active' : '' }}" href="{{ url('auteur') }}">Auteurs</a></li>
        <li><a class="{{ Request::is( 'contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a></li>
    </ul>
</nav>