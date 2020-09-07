<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <title>GitHub dashboard</title>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        @if(isset($repository))
            <a class="navbar-brand" href="/">{{ $repository['owner'] . ' / ' . $repository['repo'] }}</a>
        @endif

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                @if($notAuthorize)
                    <li class="nav-active">
                        <a class="nav-link" href="/login">Sign in</a>
                    </li>
                @else
                    <li class="nav-active">
                        <a class="nav-link" href="/logout">Sign out</a>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <form method="POST" action="/">
                    {{ csrf_field() }}

                    <div>
                        <div class="form-group col-md-4">
                            <label for="title">Owner name</label>
                            <input type="text" class="form-control" id="owner" name="owner" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="text">Repository name</label>
                            <input type="text" class="form-control" id="repo" name="repo" required>
                        </div>

                        <button type="submit" class="btn btn-success ml-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="container">

            @if($errors->any())
                <hr>
                <div class="form-group">
                    <div class="alert alert-warning" role="alert">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            @yield('content')

        </div>
    </body>
</html>
