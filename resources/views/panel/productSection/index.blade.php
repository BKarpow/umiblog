@extends('layouts.panel')

@section('title') Розділи продуктів  @endsection

@section('header')
    @include('panel.inc.header')
@endsection

@section('content')
    <h2 class="text-center">Розділи</h2>
    <section-main />
    @if (!$sections->count())
        <h3 class="text-center">Немає покищо розділів</h3>
        <!-- /.text-center -->
    @else
        @foreach($sections as $section)
            <div class="section">
                <div class="section__title"></div>
                <!-- /.section__title -->
                <div class="section__categories">
                    @if(!$section->categories()->count())
                        <p>Немає тут категорій</p>
                    @else
                        <ul>
                        @foreach($section->categories() as $category)
                            <li>{{$category->name}}</li>
                        @endforeach
                        </ul>
                    @endif
                </div>
                <!-- /.section__categories -->
            </div>
            <!-- /.section -->
        @endforeach
    @endif;

    @if ($isPaginate)
        <div class="container mt-2">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 py-2">
                    {{$sections->links()}}
                </div>
                <!-- /.col-md-6 py-2 -->
            </div>
            <!-- /.row justify-content-center align-items-center -->
        </div>
        <!-- /.container -->
    @endif

@endsection
