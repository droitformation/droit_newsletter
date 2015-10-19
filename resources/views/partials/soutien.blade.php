@if(isset($sidebar['soutien']) && !$sidebar['soutien']->isEmpty())
    @foreach($sidebar['soutien'] as $soutien)
        <div class="soutiens">
            <h3 class="title soutien"><i class="glyphicon glyphicon-star-empty"></i> &nbsp;Avec le soutien de</h3>
            <div class="media soutien-media text-center">
                <a target="_blank" href="{{ $soutien->lien }}">
                    <img style="max-width: 130px;" src="{{ asset('uploads/'.$soutien->image) }}" alt="Soutiens" />
                </a>
            </div>
        </div>
    @endforeach
@endif
