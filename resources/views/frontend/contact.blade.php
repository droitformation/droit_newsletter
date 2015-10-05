@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-8">

        <h1>Contact</h1>

        <hr/>

        <h3>Formulaire</h3>
        <form action="{{ url('sendMessage') }}" class="form-horizontal" method="post">
            <div class="form-group">
                <label class="col-sm-2 control-label">Nom</label>
                <div class="col-sm-10">
                    <input type="text" name="nom" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <textarea name="remarque" required class="form-control" rows="3"></textarea>
                </div>
            </div>
            <input value="Envoyer" class="btn btn-default" type="submit" />
        </form><!--END CONTACT FORM-->
    </div>
    <div class="col-md-4">
        <h3>Faculté de droit</h3>
        <p><strong>Adresse</strong>: Avenue du 1er-Mars 26, 2000 Neuchâtel<br>
            <strong>Telephone</strong>: +41 32 / 718 12 22<br>
            <strong>Email</strong>: droit.formation@unine.ch
        </p>
    </div>
</div><!--END CONTENT-->

@stop
