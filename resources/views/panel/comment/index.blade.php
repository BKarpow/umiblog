@extends('layouts.panel')

@section('title') Коментарі  @endsection

@section('header')
    @include('panel.inc.header')
@endsection

@section('content')
    <h2 class="text-center">Меню</h2>
    <table class=" my-3 table table-responsive table-hover table-dark">
        <thead>
        <tr>
            <th>ID</th>
            <th>Коментар</th>
            <th>Стаття</th>
            <th>Публікація</th>
            <th>Створено</th>
        </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{$comment->id}}</td>
                <td>
                    {{$comment->comment}}

                    <!-- /.py-1 -->
                    <div class="mt-1">
                        <a href="" class="btn btn-outline-danger">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                            </svg>
                        </a>
                        <!-- /.btn btn-outline-danger -->
                    </div>
                    <!-- /.mt-1 -->
                </td>
                <td>
                    <div class="py-1">
                        <small> {{$comment->article->title}} </small>
                    </div>
                </td>
                <td>
                    <public-toggle
                        uri-toggle="{{route('panel.comment.toggle', ['commentId'=>$comment->id])}}"
                        @if ($comment->moderate) status="1" @endif
                    />
                </td>
                <td>
                    <div class="btn-group">
                    </div>
                    <!-- /.btn-group -->
                </td>
                <td>{{$comment->date()}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    @if ($isPaginate)
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 py-2">
                    {{$comments->links()}}
                </div>
                <!-- /.col-md-6 py-2 -->
            </div>
            <!-- /.row justify-content-center align-items-center -->
        </div>
        <!-- /.container -->
    @endif

@endsection
