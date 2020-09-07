<div class="container">
    <div class="row">
        <div class="blog-post">
            <h2 class="blog-post-title">
                <a href="{{ $pullRequest['url'] }}">
                    {{ $pullRequest['title'] }}
                </a>
            </h2>
            <p class="font-weight-light font-italic">#{{ $pullRequest['number'] }} opened at {{ $pullRequest['created_at'] }} by {{ $pullRequest['user'] }}</p>
            @if($closePermission)
                <a href="{{ '/update-status/' . $repository['owner'] . '/' .$repository['repo'] . '/' . $pullRequest['number'] }}">
                    Close
                </a>
            @endif
            <hr>
        </div>
    </div>
</div>
