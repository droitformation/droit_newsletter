<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Administration | Droit du travail</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Droit du travail | administration">
    <meta name="author" content="Cindy Leschaud | @DesignPond">
    <meta name="token" content="<?php echo csrf_token(); ?>">
    <link rel="stylesheet" href="<?php echo asset('admin/css/styles.css?=121');?>">
    <link rel="stylesheet" href="<?php echo asset('admin/css/newsletter.css');?>">
    <link rel="stylesheet" href="<?php echo asset('js/vendor/redactor/redactor.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('admin/css/files.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('js/vendor/jqueryui/jquery-ui.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo asset('js/vendor/jqueryui/jquery-ui.theme.css'); ?>">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

    <link rel='stylesheet' type='text/css' href="<?php echo asset('admin/plugins/datatables/dataTables.css');?>" />
    <link rel='stylesheet' type='text/css' href="<?php echo asset('admin/plugins/form-multiselect/css/multi-select.css');?>" />
    <script src="<?php echo asset('js/jquery.js');?>"></script>
    <link rel="stylesheet" href="<?php echo asset('admin/css/jquery.fileupload.css');?>">
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries. Placeholdr.js enables the placeholder attribute -->
	<!--[if lt IE 9]>
        <link rel="stylesheet" href="<?php echo asset('admin/css/styles.ie8.css');?>">
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
	<![endif]-->

    @if(isset($isNewsletter))
        <link rel="stylesheet" href="<?php echo asset('css/newsletter.css'); ?>">
    @endif

    <link rel='stylesheet' type='text/css' href='<?php echo asset('admin/plugins/form-toggle/toggles.css');?>' />
    <base href="/">

</head>

<body flow-prevent-drop>

<?php
 $current_user = (isset(Auth::user()->prenom) ? Auth::user()->prenom : '').' '.(isset(Auth::user()->prenom) ? Auth::user()->nom : '');
?>

    <header class="navbar navbar-inverse navbar-fixed-top" role="banner">

        <a id="leftmenu-trigger" class="tooltips" data-toggle="tooltip" data-placement="right" title="Toggle Sidebar"></a>

        <div class="navbar-header pull-left"><a class="navbar-brand" href="{{ url('/')  }}">Droit du travail</a></div>

        <ul class="nav navbar-nav pull-right toolbar">
            <li class="dropdown">
                <a href="#" class="dropdown-toggle username" data-toggle="dropdown">
                    <span class="hidden-xs">
                        {{ $current_user }}
                        <i class="fa fa-caret-down"></i></span>
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
        @include('admin.partials.navigation')

        <div id="page-content">
            <div id='wrap'>

                <!-- Breadcrumbs  -->
                @include('admin.partials.breadcrumbs')

                <div id="page-heading">
                    <h2>{{ $pageTitle or 'Administration' }}</h2>

                    <!-- messages and errors -->
                    @include('admin.partials.message')

                </div>

                <div class="container">

                    <!-- Contenu -->
                    @yield('content')
                    <!-- Fin contenu -->

                </div> <!-- container -->
            </div> <!--wrap -->
        </div> <!-- page-content -->

        <footer role="contentinfo">
            <div class="clearfix">
                <ul class="list-unstyled list-inline pull-left">
                    <li>Droit du travail &copy; <?php echo date('Y'); ?></li>
                </ul>
                <button class="pull-right btn btn-inverse-alt btn-xs hidden-print" id="back-to-top"><i class="fa fa-arrow-up"></i></button>
            </div>
        </footer>

    </div> <!-- page-container -->

    <script src="<?php echo asset('js/vendor/jqueryui/jquery-ui.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/enquire.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/jquery.cookie.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/jquery.nicescroll.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/plugins/form-toggle/toggle.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/placeholdr.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/fieldChooser.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/vendor/redactor/redactor.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/vendor/redactor/fr.js');?>"></script>
    <script type='text/javascript' src="<?php echo asset('admin/plugins/form-multiselect/js/jquery.multi-select.js');?>"></script>
    <script type='text/javascript' src="<?php echo asset('admin/plugins/datatables/jquery.dataTables.min.js');?>"></script>
    <script type='text/javascript' src="<?php echo asset('admin/plugins/datatables/dataTables.bootstrap.js');?>"></script>
    <script type='text/javascript' src="<?php echo asset('admin/plugins/form-datepicker/js/bootstrap-datepicker.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/datatables.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('admin/js/application.js');?>"></script>
    <script type='text/javascript' src="<?php echo asset('admin/plugins/mixitup/jquery.mixitup.min.js');?>"></script>
    <script type='text/javascript' src="<?php echo asset('admin/plugins/bootbox/bootbox.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/utils.js');?>"></script>

    @if(isset($isFileManager))
        <script type="text/javascript" src="<?php echo asset('admin/js/files.js');?>"></script>
        <script type="text/javascript" src="<?php echo asset('admin/js/upload/upload.js');?>"></script>
        <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
        <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
        <script src="<?php echo asset('admin/js/upload/jquery.iframe-transport.js');?>"></script>
        <script src="<?php echo asset('admin/js/upload/jquery.fileupload.js');?>"></script>
        <script src="<?php echo asset('admin/js/upload/jquery.fileupload-process.js');?>"></script>
        <script src="<?php echo asset('admin/js/upload/jquery.fileupload-image.js');?>"></script>
        <script src="<?php echo asset('admin/js/upload/jquery.fileupload-validate.js');?>"></script>
    @endif

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.2/angular.min.js"></script>
    <script type="text/javascript" src="<?php echo asset('js/vendor/angular/angular-drag-and-drop-lists.js');?>"></script>
    <script type="text/javascript" src="<?php echo asset('js/multiselection.js');?>"></script>

    @if(isset($isNewsletter))
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.1/angular-sanitize.js"></script>
        <script type="text/javascript" src="<?php echo asset('js/vendor/angular/angular-redactor.js');?>"></script>
        <script type="text/javascript" src="<?php echo asset('js/vendor/angular/angular-flow.js');?>"></script>
        <script type="text/javascript" src="<?php echo asset('js/build.js');?>"></script>
        <script type="text/javascript" src="<?php echo asset('js/sorting.js');?>"></script>
    @endif

</body>
</html>