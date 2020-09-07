@extends ('main')

@section ('content')

    <div class="row">

        @foreach($pullRequests as $pullRequest)
            @include ('pullRequest')
        @endforeach
    </div>

@endsection
