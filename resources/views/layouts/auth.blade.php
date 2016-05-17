<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>RCAssurances</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="DroitNE | login">
    <meta name="author" content="Cindy Leschaud | @DesignPond">

    <link rel="stylesheet" href="<?php echo asset('backend/css/styles.css?=121');?>">
    <link rel="stylesheet" href="<?php echo asset('backend/css/login.css?=121');?>">
    <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600' rel='stylesheet' type='text/css'>

</head>
<body class="focusedform">

<div class="verticalcenter">
    @if( $errors->has() || Session::has('status') || Session::has('error'))

        <div class="alert alert-warning }}">

            @foreach($errors->all() as $message)
                <p>{{ $message }}</p>
            @endforeach

            @if(Session::has('message'))
                {{ Session::get('message') }}
            @endif

            @if(Session::has('error'))
                {{ Session::get('error') }}
            @endif

            @if(Session::has('status'))
                {{ Session::get('status') }}
            @endif

        </div>

    @endif

    <div id="logo"><a href="{{ url('/') }}">RC Assurances</a></div>
    <div class="panel panel-primary">

        <!-- Contenu -->
        @yield('content')
        <!-- Fin contenu -->

    </div>
</div>

</body>
</html>