<a id="{{ $bloc->template }}" class="blocEdit" rel="{{ $bloc->id }}">
    <img src="<?php echo asset('images/blocs/'.$bloc->image); ?>" alt="{{ $bloc->titre }}" />
    <span>{{ $bloc->titre }}</span>
</a>