<!DOCTYPE html>
    <!--[if IE 8]><html class="no-js lt-ie9" lang="en" > <![endif]-->
    <!--[if gt IE 8]><!--> <html class="no-js" lang="en" > <!--<![endif]-->
    <head>
        <meta charset="utf-8" />
        <title>RC Assurances</title>

        <meta name="description" content="RC Assurances, L'actualité dans les domaines des assurances et de la RC">
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
        <link rel="stylesheet" type="text/css" href="<?php echo asset('frontend/css/styleRCA.css');?>">
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
         <div class="col-md-3 col-sm-3 col-xs-6">
         <a href="{{ url('/') }}"><div id="logo"></div></a>
         </div>
         <div class="col-md-7 col-sm-7 col-xs-7">
         	<!-- Navigation  -->
          	@include('partials.navigation')
         </div>
        <div class="col-md-2 logo-nav text-right">
            <a target="_blank" href="http://www2.unine.ch/droit"><img src="{{ asset('files/UniNE_logo_90x58.png') }}" alt=""></a>
		</div>            
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
            <div class="col-md-12">
            	<div class="bloc-soutien">
                <img src="{{ asset('files/pict_FSA_77x80.jpg') }}">
                    <h5>Association des avocats spécialistes FSA<br>Responsabilité civile & droit des assurances</h5>
                    Tous les membres ont acquis une formation complémentaire étendue ou disposent déjà de vastes connaissances
                    dans le domaine du droit de la responsabilité civile et du droit des assurances.
                </div>
            </div>
   {{--         <div class="col-md-6">
            	<div class="bloc-soutien">
                <img src="{{ asset('files/CERT-logo.png') }}">
                <h5>CERT Centre d'étude des relations de travail</h5>
                Le CERT, rattaché à la faculté de droit de l'Université de Neuchâtel, est à la disposition des entreprises, des administrations publiques et de tous les autres milieux intéressés aux questions relatives au droit du travail et, plus largement, à la relation d'emploi.
                </div>
            </div>--}}
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

        </div></div><!-- END Container -->

    </body>
</html>