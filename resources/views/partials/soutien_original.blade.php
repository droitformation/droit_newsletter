@if(isset($sidebar['soutien']) && !$sidebar['soutien']->isEmpty())
    @foreach($sidebar['soutien'] as $soutien)
        <div class="soutiens">
            <h4>Avec le soutien de</h4>
            <div class="media soutien-media text-center">
                <a target="_blank" href="{{ $soutien->lien }}">
                    <img style="max-width: 130px;" src="{{ asset('uploads/'.$soutien->image) }}" alt="Soutiens" />
                </a>
            </div>
        </div>
    @endforeach
@endif
