@extends('layouts.app')

@section('title') {{$tag}} @endsection



@section('header')
    @include('inc.header')
@endsection

@section('content')
    <div class="container">
      <div class="row">
        <div class="col-md-11">
          <h2>Для тегу {{$tag}}</h2>
          <articles-tag tag="{{$tag}}" />
        </div>
        <!-- /.col-md-11 -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container -->
@endsection
