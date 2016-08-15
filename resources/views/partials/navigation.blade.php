<!-- Original -->
<nav class="navbar">
    <ul class="nav navbar-nav pull-right">
        <li><a class="{{ Request::is( '/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a></li>
        <li><a class="{{ Request::is( 'jurisprudence') ? 'active' : '' }}" href="{{ url('jurisprudence') }}">Jurisprudence</a></li>
        @if(isset($newsletters))
            <li><a href="{{ url('newsletter/campagne/'.$newsletters->sent->first()->id) }}">Newsletter</a></li>
        @endif
        <li><a class="{{ Request::is( 'auteur') ? 'active' : '' }}" href="{{ url('auteur') }}">Auteurs</a></li>
        <li><a class="{{ Request::is( 'contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a></li>
    </ul>
</nav>

 <!-- END Container -->