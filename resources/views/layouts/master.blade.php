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
        <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,300,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?php echo asset('frontend/css/filter.css');?>">
        <link rel="stylesheet" type="text/css" href="<?php echo asset('frontend/css/chosen.css');?>">
        <link rel="stylesheet" type="text/css" href="../../../public/frontend/css/styleRCA.css">
        <!-- Javascript Files
        ================================================== -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.0.0.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo asset('frontend/js/chosen.jquery.js');?>"></script>
        <script src="<?php echo asset('frontend/js/filter.js');?>"></script>

    </head>

    <body>

    <div class="container">
<div id="blue-line"></div>
            <!-- START HEADER -->
            <nav class="row navbar">
                <div class="col-md-2 col-xs-12">
                <a href="#"><div id="logo"></div></a>
                </div>
                <div class="col-md-6 col-xs-12">
                    <!-- Navigation  -->
                    @include('partials.navigation')
                </div>
                <div class="col-md-4 logo-nav">
				<a target="_blank" href="http://www2.unine.ch/droit"><img src="../../../public/files/UniNE_FD_pos_c.png" alt=""></a>
                <a target="_blank" href="http://www2.unine.ch/cert"><img src="../../../public/files/CERT.jpg" alt=""></a>
				</div>
            </nav>
       </div>   
            
		<!-- START container -->
        <div class="container">
            <!-- START CONTENT -->
            <section>

                @include('partials.message')

                <!-- Contenu -->
                @yield('content')
                <!-- Fin contenu -->

            </section><!--END CONTENT-->

            <hr/></div>
            <!-- Soutien -->
            <div class="container"><div class="row">
            <div class="col-md-6">
            	<div class="bloc-soutien">
                <h5>Association des avocats spécialistes FSA</h5>
                </div>
            </div>
            <div class="col-md-6">
            	<div class="bloc-soutien">
                <h5>CERT Centre d'étude des relations de travail</h5>
                </div>
            </div>
            </div>
            <hr/></div>
            <!-- Fin de soutien -->
            <!-- START FOOTER -->
            <footer>
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>Faculté de droit, Avenue du 1er-Mars 26, 2000 Neuchâtel</a></strong></p>
                        <p class="copyright">Copyright &copy; . Tous droits réservés.</p>
                    </div><!--END ONE-->
                    <div class="col-md-4 text-right">
                        <a class="btn btn-xs btn-default" href="{{ url('admin') }}">administration</a>
                    </div>
                </div>
                </div><!--END SECTION-->
            </footer><!--END FOOTER-->
            <!-- END FOOTER -->

        </div> <!-- END Container -->

    </body>
</html>