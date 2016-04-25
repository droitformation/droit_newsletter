@extends('backend.layouts.master')
@section('content')

<?php $helper = new \App\Droit\Helper\Helper(); ?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-xs-12">

        <div class="options text-right" style="margin-bottom: 10px;">
            <div class="btn-toolbar">
               <a href="{{ url('admin/page/create') }}" class="btn btn-success"><i class="fa fa-plus"></i> &nbsp;Ajouter</a>
            </div>
        </div>

        @if(!$root->isEmpty())
            <div class="panel panel-primary">
                <div class="panel-heading">Pages</div>
                <div class="panel-body">
                    <div id="nestable" class="dd nestable_list" style="height: auto;">

                        <ol class="dd-list">
                            @foreach($root as $page)
                                <?php echo $helper->renderNode($page); ?>
                            @endforeach
                        </ol>

                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@stop