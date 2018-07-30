<div class="newsletter">
    <h4><i class="icon-envelope"></i>&nbsp;Inscription à la newsletter</h4>

    <form action="{{ url('subscribe') }}" method="POST" class="form">
        {!! csrf_field() !!}

        <div class="input-group">
             <input type="text" class="form-control" value="" name="email" placeholder="Entrez votre email">
             <input type="hidden" name="newsletter_id" value="3">
          <span class="input-group-btn">
             <button class="btn btn-default grey" type="submit">Envoyer</button>
          </span>
        </div><!-- /input-group -->
    </form>
</div><!--END WIDGET-->

<p class="divider-border"></p>