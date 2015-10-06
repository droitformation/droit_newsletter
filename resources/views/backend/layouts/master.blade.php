<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Administration | Droit Formation</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Administration | Droit Formation">
    <meta name="author" content="Cindy Leschaud | @DesignPond">
    <meta name="_token" content="<?php echo csrf_token(); ?>">

    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/styles.css?=121');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/js/vendor/redactor/redactor.css'); ?>">
    <link rel='stylesheet' type='text/css' href="//cdn.datatables.net/plug-ins/f2c75b7247b/integration/bootstrap/3/dataTables.bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/jquery-ui.min.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/chosen.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/chosen-bootstrap.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/dropzone.css');?>">
    <link rel='stylesheet' type='text/css' href="<?php echo asset('backend/plugins/form-multiselect/css/multi-select.css');?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/admin.css');?>">
    <link rel="stylesheet" type="text/css" href="<?php echo asset('backend/css/types.css');?>">
    <link rel='stylesheet' type='text/css' href="<?php echo asset('backend/plugins/form-nestable/jquery.nestable.css');?>" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <base href="/">

</head>
<body>

<?php $current_user = (isset(Auth::user()->name) ? Auth::user()->name : ''); ?>

<header class="navbar navbar-inverse navbar-fixed-top" role="banner">

    <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>
    <div class="navbar-header pull-left"><a class="navbar-brand" href="{{ url('/')  }}">Droit Formation</a></div>

    <ul class="nav navbar-nav pull-right toolbar">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
               <span class="hidden-xs">&nbsp;{{ $current_user }}<i class="fa fa-caret-down"></i></span>
            </a>
            <ul class="dropdown-menu userinfo arrow">
                <li class="username">
                    <a href="#"><div class="pull-right"><h5>Bonjour, {{ $current_user }}!</h5></div></a>
                </li>
                <li class="userlinks">
                    <ul class="dropdown-menu">
                        <li><a href="{{ url('logout') }}"><i class="pull-right fa  fa-power-off"></i> Logout</a></li>
                    </ul>
                </li>
            </ul>
        </li>
    </ul>
</header>

<div id="page-container">

    <!-- Navigation  -->
    @include('backend.partials.navigation')

    <div id="page-content">
        <div id='wrap'>

            <div id="page-heading"><h2>{{ $pageTitle or 'Droit Formation' }} <small>Administration</small></h2></div>

            <div class="container">

                <!-- messages and errors -->
                @include('backend.partials.message')

                <!-- Contenu -->
                @yield('content')
                <!-- Fin contenu -->

            </div> <!-- container -->
        </div> <!--wrap -->
    </div> <!-- page-content -->

    <footer role="contentinfo">
        <div class="clearfix">
            <ul class="list-unstyled list-inline pull-left">
                <li>Droit Formation &copy; <?php echo date('Y'); ?></li>
            </ul>
            <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
        </div>
    </footer>

</div> <!-- page-container -->

<script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>
<script src="<?php echo asset('backend/js/validation/messages_fr.js');?>"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.js"></script>

<script type="text/javascript" src="<?php echo asset('backend/js/vendor/chosen/chosen.jquery.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/enquire.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/dropzone.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/jquery.cookie.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/jquery.nicescroll.min.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/angular/angular-flow.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/placeholdr.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/vendor/redactor/redactor.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/vendor/redactor/fr.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/vendor/redactor/imagemanager.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/vendor/redactor/filemanager.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/form-multiselect/js/jquery.multi-select.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/form-multiselect/js/jquery.quicksearch.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/datatables/dataTables.bootstrap.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/form-datepicker/js/bootstrap-datepicker.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/form-nestable/jquery.nestable.min.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/datatables.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/application.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/bootbox/bootbox.min.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/js/nestable.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/js/Sortable.min.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/js/selectize.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/plugins/form-stepy/jquery.stepy.js');?>"></script>
<script type='text/javascript' src="<?php echo asset('backend/js/formwizard.js');?>"></script>

<script type="text/javascript" src="<?php echo asset('backend/js/admin.js');?>"></script>
<script type="text/javascript" src="<?php echo asset('backend/js/upload.js');?>"></script>
</body>
</html>