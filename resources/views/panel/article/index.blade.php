@extends('layouts.panel')

@section('title') Всі статті @endsection

@section('header')
    @include('panel.inc.header')
@endsection

@section('content')
        <h2 class="text-center">Статті</h2>
        <div class="btn-group">
            <a href="{{route('panel.article.create')}}" class="btn btn-success">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                </svg> Створити нову статтю
            </a>
            <!-- /.btn btn-success -->
        </div>
        <!-- /.btn-group -->
        <div class="mt-2">
            @if ($articles->count() == 0)
                <h3 class="text-center">Записів поки-що не створено, вибачте :(</h3>
                <div class="my-2 d-flex justify-content-center align-items-center">
                    <a href="{{route('panel.article.create')}}" class="btn btn-success">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus-fill" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M2 15.5V2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.74.439L8 13.069l-5.26 2.87A.5.5 0 0 1 2 15.5zm6.5-11a.5.5 0 0 0-1 0V6H6a.5.5 0 0 0 0 1h1.5v1.5a.5.5 0 0 0 1 0V7H10a.5.5 0 0 0 0-1H8.5V4.5z"/>
                        </svg> Створити нову статтю
                    </a>
                    <!-- /.btn btn-success -->
                </div>
                <!-- /.mt-2 d-flex justify-content-center align-items-center -->
                <!-- /.text-center -->
            @else
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Заголовок</th>
                        <th>Теги</th>
                        <th>Датв</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($articles as $article)
                        <tr>
                            <td>{{$article->id}}</td>
                            <td>
                                {{$article->title}}
                                <div class="control-panel mt-1">
                                    <div class="btn-group">
                                        <a
                                            href="{{route('panel.article.delete', ['id'=>$article->id])}}"
                                            title="Видалити статтю" class="btn btn-outline-danger">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                            </svg>
                                        </a>
                                        <!-- /.btn btn-outline-danger -->
                                    </div>
                                    <!-- /.btn-group -->
                                </div>
                                <!-- /.control-panel -->

                            </td>
                            <td> {!!
$article->tagsToString('<a href="" class="btn btn-primary">', '</a>', true, '  ')
!!} </td>
                            <td>{{$article->created_at->format('d-m-Y H:i:s')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                @if ($isPaginate)
                    <div class="container mt-3">
                        <div class="row justify-content-center align-items-center">
                            <div class="col-md-6 py-2">
                                {{$articles->links()}}
                            </div>
                            <!-- /.col-md-6 py-2 -->
                        </div>
                        <!-- /.row justify-content-center align-items-center -->
                    </div>
                    <!-- /.container -->
                @endif
            @endif
        </div>
        <!-- /.mt-2 -->

@endsection
