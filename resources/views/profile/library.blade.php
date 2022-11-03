@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Добро пожаловать в библиотеку {{ $user->name }}</div>
                    <div class="card-body">
                        <div class="row">
                            <ul class="media-list">
                                @foreach ($books as $book)
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-3"> {{$book->name}} </div>
                                                    <div class="col-3" align="center"> <button class="btn btn-primary"
                                                                                               onClick='location.href="{{
    route('profile.readbook', ['userId' => Auth::user()->id, 'bookname' => $book->name])
    }}"'>
                                                            Прочитать книгу </button> </div>
                                                    <div class="col-3" align="center"> <button class="btn btn-secondary"
                                                                                               onClick='location.href="{{
    route('profile.editbook', ['userId' => Auth::user()->id, 'bookname' => $book->name])
    }}"'>
                                                            Редактировать книгу </button> </div>
                                                    <div class="col-3" align="center"> <button class="btn btn-danger"> Удалить книгу </button> </div>
                                                </div>
                                            </div>
                                            <hr>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
