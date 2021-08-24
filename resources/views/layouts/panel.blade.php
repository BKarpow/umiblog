<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('js/sm/summernote.min.css') }}" rel="stylesheet">
    <script src="{{asset('/js/sm/summernote.min.js')}}" defer></script>
    <script src="{{asset('/js/sm/summernote-uk-UA.min.js')}}" defer></script>
    <script src="{{asset('/js/summernote_editor_settings.js')}}" defer></script>
<body>
<div id="app">
    @yield('header')

    <main class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="card">
                        <div class="card-header">@yield('title')</div>

                        <div class="card-body">
                            @if ($errors->any())
                                @foreach($errors->all() as $error)
                                    <div class="alert my-1 alert-warning"><strong>
                                            {{$error}}
                                        </strong></div>
                                    <!-- /.alert alert-warning -->
                                @endforeach
                            @endif
                            @if (session('status'))
                                <div class="mb-4 alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            @yield('content')
                        </div>
                    </div>

                </div>
                <!-- /.col-md-11 -->
            </div>
            <!-- /.row justify-content-center -->
        </div>
        <!-- /.container -->

    </main>
</div>
</body>
</html>
