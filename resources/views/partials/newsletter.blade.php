<div class="newsletter">
    <h3 class="title"><i class="icon-envelope"></i> &nbsp;Inscription à la newsletter</h3>
    {{ Form::open(array('url' => 'inscription')) }}

        <div class="input-group">
             <input type="text" class="form-control" value="" name="email" placeholder="Entrez votre email">
             <input type="hidden" name="newsletter_id[]" value="1">
          <span class="input-group-btn">
             <button class="btn btn-default grey" type="submit">Envoyer</button>
          </span>
        </div><!-- /input-group -->

    {{ Form::close() }}
</div><!--END WIDGET-->

<p class="divider-border"></p>