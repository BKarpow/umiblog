@extends('layouts.app')

@section('title') {{$article->title}} @endsection

@section('meta')
    <meta name="description" content="{{$article->shortContent()}}">
@endsection

@section('header')
    @include('inc.header')
@endsection

@section('content')
    <div class="container">
        <div class="row mt1 justify-content-center">
            <div class="col-md-10 article" >
                <article>
                    <header>
                        <h1>{{$article->title}}</h1>
                        <div class="meta">
                            <span class="date">{{$article->getCreateDate()}}</span>
                            <span class="author">{{$article->getAuthorName()}}</span>
                            <span class="views">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
  <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
  <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
</svg>
                                Переглядів: {{$article->views}}
                            </span>
                            <!-- /.author -->
                        </div>
                    </header>
                    <main>
                        <p align="center">
                            <img
                                class="img-fluid"
                                src="{{$article->image}}"
                                alt="{{$article->title}}">
                        </p>
                        {!! $article->content !!}
                    </main>
                    <footer>
                        <div class="tags">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                 width="16"
                                 height="16" fill="currentColor" class="bi bi-tags-fill" viewBox="0 0 16 16">
                                <path d="M2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2zm3.5 4a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3z"/>
                                <path d="M1.293 7.793A1 1 0 0 1 1 7.086V2a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l.043-.043-7.457-7.457z"/>
                            </svg>
                            {!! $article->getTagsString() !!}
                        </div>
                        <!-- /.tags -->
                    </footer>
                </article>
                <div id="comments" class="mt-2 p-1">
                    <comments article-id="{{$article->id}}" ></comments>
                </div>
                <!-- /#comments.mt-2 -->
            </div>
            <!-- /.col-md-10 -->
        </div>
        <!-- /.row mt1 justify-content-center -->
    </div>
    <!-- /.container -->
@endsection
