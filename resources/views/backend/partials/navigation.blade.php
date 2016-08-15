<!-- BEGIN SIDEBAR -->
<nav id="page-leftbar" role="navigation">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="acc-menu" id="sidebar">
        <!-- Recherche globale -->
       <!-- @include('backend.partials.search')-->

        <li class="<?php echo (Request::is('admin') ? 'active' : '' ); ?>"><a href="{{ url('admin') }}"><i class="fa fa-home"></i> <span>Accueil</span></a></li>
        <li class="divider"></li>
        <li class="<?php echo (Request::is('admin/contenu') ? 'active' : '' ); ?>"><a href="{{ url('admin/contenu') }}"><i class="fa fa-reorder"></i> <span>Contenus</span></a></li>
        <li class="<?php echo (Request::is('admin/author') ? 'active' : '' ); ?>"><a href="{{ url('admin/author') }}"><i class="fa fa-user"></i> <span>Auteurs</span></a></li>
        <li class="<?php echo (Request::is('admin/arret/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/arret')  }}"><i class="fa fa-edit"></i> <span>Arrêts</span></a></li>
        <li class="<?php echo (Request::is('admin/analyse/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/analyse')  }}"><i class="fa fa-dot-circle-o"></i> <span>Analyses</span></a></li>
        <li class="<?php echo (Request::is('admin/parent/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/parent') }}"><i class="fa fa-th-list"></i> <span>Categories parente</span></a></li>
        <li class="<?php echo (Request::is('admin/categorie/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/categorie')  }}"><i class="fa fa-list-ul"></i> <span>Categories</span></a></li>
        <li class="<?php echo (Request::is('admin/page/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/page')  }}"><i class="fa fa-edit"></i> <span>Pages</span></a></li>
        <li class="<?php echo (Request::is('admin/user/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/user')  }}"><i class="fa fa-user"></i> <span>Utilisateurs</span></a></li>

        <li class="divider"></li>

        <li class="<?php echo (Request::is('build/newsletter/*') || Request::is('build/campagne/*') || Request::is('build/subscriber/*') ? 'active' : '' ); ?>">
            <a href="javascript:;"><i class="fa fa-envelope"></i><span>Newsletters</span></a>
            <ul class="acc-menu">
                <li class="<?php echo (Request::is('build/newsletter/*') ? 'active' : '' ); ?>"><a href="{{ url('build/newsletter')  }}">Liste des campagnes</a></li>
                <li class="<?php echo (Request::is('build/subscriber/*') ? 'active' : '' ); ?>"><a href="{{ url('build/subscriber')  }}">Abonnés</a></li>
                <li class="<?php echo (Request::is('build/import') ? 'active' : '' ); ?>"><a href="{{ url('build/import')  }}">Importer une liste</a></li>
                <li class="<?php echo (Request::is('build/liste') ? 'active' : '' ); ?>"><a href="{{ url('build/liste')  }}">Liste hors campagnes</a></li>
            </ul>
        </li>

    </ul>
    <!-- END SIDEBAR MENU -->
</nav>