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
        <li class="<?php echo (Request::is('admin/contenu') ? 'active' : '' ); ?>"><a href="{{ url('admin/contenu') }}"><i class="fa fa-reorder"></i> <span>Contenus</span></a></li>
        <li class="<?php echo (Request::is('admin/author') ? 'active' : '' ); ?>"><a href="{{ url('admin/author') }}"><i class="fa fa-user"></i> <span>Auteurs</span></a></li>
        <li class="<?php echo (Request::is('admin/arret/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/arret')  }}"><i class="fa fa-edit"></i> <span>Arrêts</span></a></li>
        <li class="<?php echo (Request::is('admin/analyse/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/analyse')  }}"><i class="fa fa-dot-circle-o"></i> <span>Analyses</span></a></li>
        <li class="<?php echo (Request::is('admin/parent/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/parent') }}"><i class="fa fa-th-list"></i> <span>Categories parente</span></a></li>
        <li class="<?php echo (Request::is('admin/categorie/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/categorie')  }}"><i class="fa fa-list-ul"></i> <span>Categories</span></a></li>
        <li class="<?php echo (Request::is('admin/page/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/page')  }}"><i class="fa fa-edit"></i> <span>Pages</span></a></li>
        <li class="divider"></li>

        <li class="<?php echo (Request::is('admin/newsletter/*') || Request::is('admin/campagne/*') || Request::is('admin/subscriber/*') ? 'active' : '' ); ?>">
            <a href="javascript:;"><i class="fa fa-envelope"></i><span>Newsletters</span></a>
            <ul class="acc-menu">
                <li class="<?php echo (Request::is('admin/newsletter/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/newsletter')  }}">Liste des newsletters</a></li>
                <li class="<?php echo (Request::is('admin/subscriber/*') ? 'active' : '' ); ?>"><a href="{{ url('admin/subscriber')  }}">Abonnées</a></li>
                <li class="<?php echo (Request::is('admin/import') ? 'active' : '' ); ?>"><a href="{{ url('admin/import')  }}">Importer une liste</a></li>
            </ul>
        </li>

    </ul>
    <!-- END SIDEBAR MENU -->
</nav>