@extends('layouts.panel')

@section('title') Створення пункту меню @endsection

@section('content')
    <h2 class="text-center">Створення меню</h2>
    <!-- /.text-center -->
    <form action="{{route('panel.menu.create.action')}}" method="POST">
       @csrf
        <div class="form-group">
            <label for="name_menu">Група меню</label>
            <input
                type="text"
                name="name_menu"
                id="name_menu"
                placeholder="Назва групи меню"
                class="form-control"
            >
            <!-- /.form-control -->
            @error('name_menu')
            <div class="alert alert-danger">
                <strong>{{$message}}</strong>
            </div>
            <!-- /.alert alert-danger -->
            @enderror
        </div>
        <!-- /.form-group -->

        <div class="form-group">
            <label for="href">Повилання</label>
            <input
                type="text"
                name="href"
                id="href"
                placeholder="Куди перейти"
                class="form-control"
            >
            <!-- /.form-control -->
            @error('href')
            <div class="alert alert-danger">
                <strong>{{$message}}</strong>
            </div>
            <!-- /.alert alert-danger -->
            @enderror
        </div>
        <!-- /.form-group -->

        <div class="form-group">
            <label for="title">Назва</label>
            <input
                type="text"
                name="title"
                id="title"
                placeholder="Назва"
                class="form-control"
            >
            <!-- /.form-control -->
            @error('title')
            <div class="alert alert-danger">
                <strong>{{$message}}</strong>
            </div>
            <!-- /.alert alert-danger -->
            @enderror
        </div>
        <!-- /.form-group -->

        <check-box name="target">Відкривати на окремі вкладці</check-box>
        <check-box name="route">Використовуется роут</check-box>

        <div class="form-group">
            <button class="btn btn-success btn-lg">
                + Створити пункт
            </button>
            <!-- /.btn btn-success btn-lg -->
        </div>
        <!-- /.form-group -->

    </form>
@endsection
