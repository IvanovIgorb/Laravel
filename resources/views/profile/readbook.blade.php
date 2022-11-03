@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Добро пожаловать, {{ Auth::user()->name }}</div>
                    <div class="card-body">
                        <div class="row">
                            <ul class="media-list">
                                @foreach ($books as $book)
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-3"> {{$book->name}} </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-9"> {{$book->text}} </div>
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
