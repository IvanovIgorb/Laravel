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
                                                        @if($comm->parent_text == "")
                                                            <div class="parentText"><q> Комментарий удален</q></div>
                                                        @else
                                                            <div class="parentText"><q>{{$comm->parent_text}}</q></div>
                                                        @endif
                                                    @endif
                                                    <div class="media-heading">
                                                        <div class="author">{{$comm->name}}</div>
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
                                                                    <input name="parent" type="hidden" value="{{ $comm->id }}">

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
                        <div id="fun">
                            <button id="example-1">Click to update</button>
                        </div>
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
        <script type="text/javascript">
            $(document).ready(function(){
                // вешаем на клик по элементу с id = example-1
                $('#example-1').click(function(){
                    $.ajax({
                        type: "GET",
                        url: '{{ route('profile.index', ['username' => Auth::user()->id]) }}',
                        datatype: "json",
                        success: function (response){
                            console.log(response.comments);
                        }
                    });
                    // загрузку HTML кода из файла example.html
                })
            });
        </script>



@endsection
