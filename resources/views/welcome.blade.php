@extends('layouts.app')

@section('title') Головна сторінка @endsection

@section('header')
    @include('inc.header')
@endsection

@section('content')
    <div class="article__list">
        @foreach($articles as $article)
            <cart-panel
                title="{{$article->title}}"
                image="{{$article->image}}"
                short-content="{{$article->shortContent()}}"
                href="{{$article->href()}}"
            >
            </cart-panel>
        @endforeach
    </div>
    <!-- /.article__list -->
@endsection
