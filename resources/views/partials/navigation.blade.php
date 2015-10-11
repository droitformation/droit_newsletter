<nav class="navbar">
    <ul class="nav navbar-nav">
        <li><a class="{{ Request::is( '/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a></li>
        <li><a class="{{ Request::is( 'jurisprudence') ? 'active' : '' }}" href="{{ url('jurisprudence') }}">Jurisprudence</a></li>
        <li><a class="{{ Request::is( 'newsletter') ? 'active' : '' }}" href="{{ url('newsletter') }}">Newsletter</a></li>
        <li><a class="{{ Request::is( 'auteur') ? 'active' : '' }}" href="{{ url('auteur') }}">Auteurs</a></li>
        <li><a class="{{ Request::is( 'contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a></li>
    </ul>
</nav>