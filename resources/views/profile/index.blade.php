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
                                        <div class="mb-3"><input type="submit" name="send" value="Отправить"></div>
                                    </div>
                                </div>
                            </form>
                            @endcan
                            <ul class="media-list">
                                @foreach ($comments as $comm)
                                    <li class="media">
                                        <div class="row-cols-2">
                                            <div class="col-4">
                                                <div class="media-body">
                                                    @if($comm->parent_id != "0")
                                                        <div class="parentText"><q>{{$comm->parent_id}}</q></div>
                                                    @endif
                                                    <div class="media-heading">
                                                        <div class="author">{{$comm->name}}</div>
                                                        <div class="author">{{$comm->author_id}}</div>
                                                        <div class="media-text text-justify">{{$comm->title}}</div>
                                                    </div>
                                                    <div class="media-text text-justify"> {{$comm->text}} </div>

                                                    <div class="metadata">
                                                        <span class="date">{{$comm->created_at}}</span>
                                                    </div>

                                                    <div class="footer-comment">
                                                        @can('view-protected-part',\App\Http\Controllers\ProfileController::class)
                                                            <form action="" method="post">
                                                                @csrf
                                                                <div class="col-md-8">
                                                                    <div class="mb-3">
                                                                        <input name="title" type="text" placeholder="Заголовок сообщения" required>

                                                                    </div>
                                                                    <div class="mb-3"><textarea name="text" id="comments" placeholder="Оставьте сообщение!"
                                                                                                required></textarea></div>
                                                                    <input name="authorId" type="hidden" value="{{ Auth::user()->id }}">
                                                                    <input name="userId" type="hidden" value="{{ $user->id }}">
                                                                    <input name="parent" type="hidden" value="{{ $comm->text }}">

                                                                    <div class="mb-3">
                                                                        <input type="submit" name="send" value="Ответить">

                                                                    </div>
                                                                </div>
                                                            </form>
                                                            @can('delete-permission', [$user->id, $comm->author_id])
                                                            <form action="" method="post">
                                                                @csrf
                                                                <input name="userId" type="hidden" value="{{ $user->id }}">
                                                                <input name="commId" type="hidden" value="{{ $comm->id }}">
                                                                <input type="submit" name="delete" value="Удалить">
                                                            </form>
                                                            @endcan
                                                        @endcan
                                                    </div>
                                                    <hr>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div ></div>
                                            </div>
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
