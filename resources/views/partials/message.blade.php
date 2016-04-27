@if( (isset($errors) && $errors->has()) || Session::has('status'))

    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-dismissable alert-{{ Session::get('status') }}">

                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                @foreach($errors->all() as $message)
                    <p>{!! $message !!}</p>
                @endforeach

                @if(Session::has('message'))
                    <p>{!! Session::get('message') !!}</p>
                @endif

                @if( Session::has('jeton') || Session::has('resend') )

                    <form action="{{ url('resend') }}" method="POST" class="form">
                        {!! csrf_field() !!}
                        <input type="hidden" value="{{ old('email') }}" name="email" />
                        <input type="hidden" value="{{ old('newsletter_id') }}" name="newsletter_id" />
                        <button class="btn btn-xs btn-warning" type="submit">Renvoyer le lien d'activation</button>
                   </form>

                @endif

            </div>
        </div>
    </div>

@endif
