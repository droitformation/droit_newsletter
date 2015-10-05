
@extends('layouts.master')
@section('content')

    <div class="page-header text-align-left">

        <div class="row">
            <div class="col-md-8">
                <h1 class="title uppercase">Colloque</h1>
            </div>
            <div class="col-md-4 text-right">
                @include('partials.soutien')
            </div>
        </div>

    </div><!--END PAGE-HEADER-->

    <div class="row">
        <div id="inner-content" class="col-md-8 col-xs-12">

            @if(!$colloques->isEmpty())

                @foreach($colloques as $name => $centre)

                    <h4 class="title-section">
                        <a target="_blank" href="http://www2.unine.ch/cert"><img src="<?php echo asset('images/logos/'.$name.'.jpg');?>" alt="{{ $name }}" /></a>
                    </h4>

                    @foreach($centre as $colloque)

                        <div class="post">
                            <div class="post-holder">
                                <div class="post-content">

                                    <?php
                                    setlocale(LC_ALL, 'fr_FR.UTF-8');
                                    $date  = \Carbon\Carbon::createFromFormat('Y-m-d', $colloque['event']['dateDebut']);
                                    $delai = \Carbon\Carbon::createFromFormat('Y-m-d', $colloque['event']['DelaiInscription']);
                                    ?>

                                    <div class="post-date">
                                        <ul>
                                            <li class="date">
                                                <span class="day">{{ $date->day }}</span><span class="month">{{ $date->formatLocalized('%B') }}</span> <span class="year">{{ $date->year }}</span>
                                            </li>
                                        </ul>
                                    </div><!--END POST-DATE-->

                                    <div class="post-title">
                                        <h2 class="title">
                                            <a target="_blank" href="http://www.publications-droit.ch/index.php?id=275#/item/59">{{ $colloque['event']['titre'] }}<br/>
                                                <strong>{{ $colloque['event']['soustitre'] }}</strong></a>
                                        </h2>
                                    </div><!--END POST-TITLE-->

                                    <div class="post-entry">
                                        <p>{{ $colloque['event']['remarques'] }}</p>
                                        @if(isset($colloque['programme']['url']))
                                            <a target="_blank" href="{{ $colloque['programme']['url'].$colloque['programme']['filename'] }}">
                                                &nbsp;<i class="fa fa-file-o"></i> &nbsp;&nbsp;Le programme
                                            </a>
                                        @endif
                                        <dl class="dl-horizontal">
                                            <dt>Lieu:</dt>
                                            <dd>{{ $colloque['event']['endroit'] }}</dd>
                                            <dt>Date:</dt>
                                            <dd>{{ $date->format('d/m/y') }}</dd>
                                            <dt>Délai d'inscription:</dt>
                                            <dd>{{ $delai->format('d/m/y') }}</dd>

                                            <dt>Prix d'inscription:</dt>
                                            @if(!empty($colloque['prix']))
                                                @foreach($colloque['prix'] as $prix)
                                                    <dd>{{ $prix['remarquePrix'] }} <strong>CHF {{ $prix['Prix'] }}</strong></dd>
                                                @endforeach
                                            @endif
                                        </dl>
                                        <p><a target="_blank" href="http://www.publications-droit.ch/index.php?id=275#/item/{{ $colloque['event']['id_Colloque'] }}" class="button small grey">Inscription</a></p>

                                    </div><!--END POST-ENTRY-->

                                </div><!--END POST-CONTENT -->
                            </div><!--END POST-HOLDER -->
                        </div><!--END POST-->

                    @endforeach
                @endforeach

            @endif

            <div class="post nomarg">
                <div class="post-holder">
                    <div class="post-content">
                        <div class="post-date">
                            <ul>
                                <li class="date"><span class="day">6</span><span class="month">Novembre</span> <span class="year">2015</span></li>
                            </ul>
                        </div><!--END POST-DATE-->
                        <div class="post-title">
                            <h2 class="title">
                                Formation continue des avocats
                            </h2>
                        </div><!--END POST-TITLE-->
                    </div><!--END POST-CONTENT -->
                </div><!--END POST-HOLDER -->
            </div><!--END POST-->

            @if(!$archives->isEmpty())

            <h3>Archives</h3>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

                @foreach($archives as $year => $colloques)
                <div class="panel panel-default">
                    <div class="panel-heading accordion-panel" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse_{{ $year }}" aria-expanded="true" aria-controls="collapseOne">
                                Année {{ $year }}
                            </a>
                        </h4>
                    </div>
                    <div id="collapse_{{ $year }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            @if($colloques)
                                @foreach($colloques as $organisateur => $list)

                                    <h4>{{ $organisateur }}</h4>

                                    @foreach($list as $colloque)
                                        <p>
                                            <?php
                                                setlocale(LC_ALL, 'fr_FR.UTF-8');
                                                $date  = \Carbon\Carbon::createFromFormat('Y-m-d', $colloque['event']['dateDebut']);
                                            ?>

                                            <a target="_blank" href="http://www.publications-droit.ch/index.php?id=275#/item/{{ $colloque['event']['id_Colloque'] }}">
                                                <i class="glyphicon glyphicon-inbox"></i> &nbsp;{{ $colloque['event']['titre'] }}
                                            </a>
                                            | <small>{{ $date->formatLocalized('%d %B %Y') }}</small>
                                        </p>
                                    @endforeach
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif

        </div><!--END CONTENT-->

        <!-- Sidebar  -->
        <div id="sidebar" class="col-md-4 col-xs-12">
            @include('partials.newsletter')
            @include('partials.pub')
            @include('partials.latest')
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->

@stop