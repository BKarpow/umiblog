@extends('layouts.panel')

@section('title') Створення статті @endsection

@section('content')
    <h2 class="text-center">Створення статті</h2>
    <!-- /.text-center -->
    <form action="{{route('panel.article.create.action')}}" method="POST">
        @csrf

        <new-title > </new-title>

        <div class="form-group">
            <label for="short_content">Короткий опи статті</label>
            <textarea name="short_content" id="short_content" cols="30" rows="10" class="form-control"></textarea>
            <!-- /#.form-control -->
        </div>
        <!-- /.form-group -->

        <div class="form-group">
            <label for="content">Вміст статті</label>
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
            <!-- /#content -->
        </div>
        <!-- /.form-group -->
        <tags></tags>
        <source-field></source-field>

        <check-box name="public" :check="true">Опублікувати</check-box>
        <check-box name="main" >На головну</check-box>
        <check-box name="top">Закріпити зверху</check-box>
        <check-box name="important">Важлива стаття</check-box>
        <check-box name="red">Червона стаття</check-box>
        <check-box name="green">Зелена стаття</check-box>
        <check-box name="blue">Синя стаття</check-box>
        <check-box name="fake">Фейкова стаття</check-box>
        <check-box name="doubt">Недовіряти статті</check-box>

        <load-image>Фото статті</load-image>

        <div class="form-group">
            <button class="btn btn-success btn-lg">
                + Створити статтю
            </button>
            <!-- /.btn btn-success btn-lg -->
        </div>
        <!-- /.form-group -->

    </form>
@endsection
