<!-- BEGIN SIDEBAR -->
<nav id="page-leftbar" role="navigation">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="acc-menu" id="sidebar">
        <!-- Recherche globale -->
       <!-- @include('backend.partials.search')-->

        <li class="<?php echo (Request::is('admin') ? 'active' : '' ); ?>"><a href="{{ url('admin') }}"><i class="fa fa-home"></i> <span>Accueil</span></a></li>
        <li class="<?php echo (Request::is('admin/config') || Request::is('admin/config/*') ? 'active' : '' ); ?>">
            <a href="{{ url('admin/config') }}">
                <i class="fa fa-cog"></i> <span>Configurations</span>
            </a>
        </li>
        <li class="divider"></li>
        <li class="<?php echo (Request::is('admin/campagne') || Request::is('admin/subscriber') || Request::is('admin/campagne/*') || Request::is('admin/subscriber/*') ? 'active' : '' ); ?>">
            <a href="javascript:;"><i class="fa fa-envelope"></i><span>Newsletter</span></a>
            <ul class="acc-menu">
                <li class="<?php echo (Request::is('admin/campagne/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/campagne')  }}">Campagnes</a></li>
                <li class="<?php echo (Request::is('admin/subscriber/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/subscriber')  }}">Abonnées</a></li>
            </ul>
        </li>

    </ul>
    <!-- END SIDEBAR MENU -->
</nav>