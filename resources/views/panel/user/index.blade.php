@extends('layouts.panel')

@section('title') Всі користувачі  @endsection

@section('header')
    @include('panel.inc.header')
@endsection

@section('content')
    <h2 class="text-center">Користувачі</h2>
    <div class="my-2">
        @include('panel.user.modalCreateNew')
    </div>
    <!-- /.my-2 -->
    <table class=" my-3 table table-responsive table-hover table-dark">
        <thead>
            <tr>
                <th>ID</th>
                <th>Імя</th>
                <th>Пошта</th>
                <th>Телефон</th>
                <th>Контроль</th>
                <th>Створено</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>
                        {{$user->name}}
                        <p><strong>{{$user->getAliasRole()}}</strong></p>
                    </td>
                    <td>
                        <strong>{{$user->email}}</strong>
                    </td>
                    <td><strong>{{$user->phone}}</strong></td>
                    <td>
                        <div class="btn-group">


                            <update-user
                                user-id="{{$user->id}}"
                                user-name="{{$user->name}}"
                                user-phone="{{$user->phone}}"
                                user-email="{{$user->email}}"
                                user-role="{{$user->role}}"
                            ></update-user>
                            @if (Auth::id() != $user->id)
                            <a
                                href="{{route('panel.user.delete', ['user_id'=>$user->id])}}"
                                class="btn btn-danger"> Видалити</a>
                            <!-- /.btn btn-danger  -->
                                @endif

                        </div>
                        <!-- /.btn-group -->
                    </td>
                    <td>{{$user->date()}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if ($isPaginate)
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6 py-2">
                    {{$users->links()}}
                </div>
                <!-- /.col-md-6 py-2 -->
            </div>
            <!-- /.row justify-content-center align-items-center -->
        </div>
        <!-- /.container -->
    @endif

@endsection
