<div class="post">
    <p class="centerText">
        <?php $lien = (isset($bloc->lien) && !empty($bloc->lien) ? $bloc->lien : url('/') ); ?>
        <a target="_blank" href="<?php echo $lien; ?>">
            <img style="max-width: 560px;" alt="Droit du bail" src="{{ asset('files/'.$bloc->image) }}" />
        </a>
    </p>
    <div class="post-title">
        <h2 class="title">{{ $bloc->titre }}</h2>
    </div>
    <span class="clear"></span>
</div>
