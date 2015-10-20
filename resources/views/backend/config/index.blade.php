@extends('backend.layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-8">

            <div class="panel panel-midnightblue">
                <form action="{{ url('admin/config') }}" method="POST" class="form">
                    {!! csrf_field() !!}

                    <div class="panel-heading">
                        <h4><i class="fa fa-edit"></i> &nbsp;Configurations</h4>
                    </div>

                    <div class="panel-body">
                        <h4>Inclure les libraires</h4>

                            <hr/>
                            <div class="form-group">
                                <label><strong>Angular</strong></label></br>
                                <?php $angular = Registry::get('scripts.angular'); ?>
                                <label class="radio-inline">
                                    <input type="radio" {{ ($angular ? 'checked' : '') }} name="scripts[angular]" value="1"> oui &nbsp;
                                </label>
                                <label class="radio-inline">
                                    <input type="radio" {{ (!$angular ? 'checked' : '') }} name="scripts[angular]" value="0"> non
                                </label>
                            </div>

                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-info pull-right">Mettre à jour</button>
                    </div>
                </form>
            </div>

        </div>
    </div>

@stop