@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Добро пожаловать на стену  {{ $user->name }}</div>

                    <div class="card-body">
                        <div class="row">
                            @can('view-protected-part',\App\Http\Controllers\ProfileController::class)
                            <form action="" method="post">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <input name="title" type="text" placeholder="Заголовок сообщения" required>

                                        </div>
                                        <div class="mb-3"><textarea name="text" id="comments" placeholder="Оставьте сообщение!"
                                                                    required></textarea></div>
                                        <input name="authorId" type="hidden" value="{{ Auth::user()->id }}">
                                        <input name="userId" type="hidden" value="{{ $user->id }}">
                                        <div class="mb-3"><input type="submit" value="Отправить"></div>
                                    </div>
                                </div>
                            </form>
                            @endcan
                            <ul class="media-list">
                                @foreach ($comments as $comm)
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="media-heading">
                                                <div class="author">{{$comm->name}}</div>
                                                <div class="author">{{$comm->title}}</div>
                                                <div class="metadata">
                                                    <span class="date">{{$comm->created_at}}</span>
                                                </div>
                                            </div>
                                            <div class="media-text text-justify"> {{$comm->text}} </div>
                                            <div class="footer-comment">
                                                <a class="btn btn-default" href="#">Ответить</a>
                                            </div>
                                            <hr>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>

                        </div>
                        <!--@if (session('status'))
                            <div class="alert alert-success" role="alert">
{{ session('status') }}
                            </div>
                        @endif-->
                            <!-- {{ __('You are logged in!') }} -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
