@extends ('main')

@section ('content')

    <div class="row">
        @if(!$message)
            <p class="mb-0"><strong>Seems like there are no open pull requests</strong></p>
        @elseIf($message === 'Not Found')
            <p class="mb-0"><strong>
                Repository not found or access denied.
                @if($notAuthorize)
                    You can <a href="/login"> log in </a> and try again
                @endif
            </strong></p>
        @else
            <p class="mb-0"><strong>{{ $message }}</strong></p>
        @endif
    </div>

@endsection
