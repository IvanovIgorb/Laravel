@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"> Изменение книги <b>{{$book->name}}</b></div>
                <div class="card-body">
                    <div class="row">
                        <ul class="media-list">
                            <li class="media">
                                <div class="media-body">
                                    <form action="" method="post">
                                        @csrf
                                        <div class="container">
                                            <div class="row">
                                                <input type="hidden" name="id" value="{{$book->id}}">
                                                <div class="col-3"> <input name="name" value="{{$book->name}}" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"> <textarea name="text" class="text"
                                                        required>{{$book->text}}</textarea> </div>
                                            </div>
                                            <div class="row">
                                                <div class="col"> <input type="submit" value="Изменить"></div>
                                            </div>
                                        </div>
                                    </form>
                                    <hr>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection