<!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>Droit</title>

        <meta name="description" content="">
        <meta name="author" content="Droit Formation Unine">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSS Files
        ================================================== -->
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,400italic,600,600italic,700italic,700,800,800italic,300italic,300' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo asset('frontend/css/filter.css');?>">
        <link rel="stylesheet" type="text/css" href="<?php echo asset('frontend/css/chosen.css');?>">
        <!-- Javascript Files
        ================================================== -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo asset('frontend/js/chosen.jquery.js');?>"></script>
        <script src="<?php echo asset('frontend/js/filter.js');?>"></script>

    </head>

    <body>

        <!-- START container -->
        <div class="container">

            <!-- START HEADER -->
            <nav class="row">
                <div class="col-md-6 col-xs-12">
                    <h1><a href="{{ url('/') }}">Droit</a></h1>
                </div>
                <div class="col-md-6 col-xs-12">
                    <!-- Navigation  -->
                    @include('partials.navigation')
                </div>
            </nav>
            <!-- END HEADER -->

            <!-- START CONTENT -->
            <section>

                @include('partials.message')

                <!-- Contenu -->
                @yield('content')
                <!-- Fin contenu -->

            </section><!--END CONTENT-->

            <hr/>
            <!-- START FOOTER -->
            <footer>
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>Faculté de droit, Avenue du 1er-Mars 26, 2000 Neuchâtel</strong></p>
                        <p class="copyright">Copyright &copy; . Tous droits réservés.</p>
                    </div><!--END ONE-->
                    <div class="col-md-4 text-right">
                        <a class="btn btn-xs btn-default" href="{{ url('admin/dashboard') }}">administration</a>
                    </div>
                </div><!--END SECTION-->
            </footer><!--END FOOTER-->
            <!-- END FOOTER -->

        </div> <!-- END Container -->

    </body>
</html>