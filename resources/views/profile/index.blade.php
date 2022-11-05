@php use App\Http\Controllers\CommentController; @endphp
@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-7">Добро пожаловать на стену {{ $user->name }}</div>
                            @if($user->id != Auth::id())
                                @if($access == 0)
                                    <div class="col-3">
                                        <form action="{{route('create.access')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <input type="submit" name="accessUpdateToY" value="Поделиться библиотекой">
                                        </form>
                                    </div>
                                @else
                                    <div class="col-3">
                                        <form action="{{route('destroy.access')}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <input type="submit" name="accessUpdateToN" value="Отключить от библиотеки">
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>


                    </div>

                    <div class="card-body">
                        <div class="row">
                            @can('view-protected-part',CommentController::class)
                                <form action="" method="post">
                                    @csrf
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <input name="title" type="text"  placeholder="Заголовок сообщения" required>
                                            </div>
                                            <div class="mb-3"><textarea name="text" id="comments" placeholder="Оставьте сообщение!"
                                                                        required></textarea>
                                            </div>
                                            <input name="authorId" type="hidden" value="{{ Auth::user()->id }}">
                                            <input name="userId" type="hidden" value="{{ $user->id }}">
                                            <div class="mb-3">
                                                <input type="submit" name="send" value="Ответить">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <hr>
                            @endcan
                            <ul class="media-list" id="commlist">
                                @foreach ($comments as $comment)
                                    @if($comment->parent_id != "0")
                                        @if($comment->parent_text == "")
                                            <div class="parentText"><q> Комментарий удален</q></div>
                                        @else
                                            <div class="parentText"><q>{{$comment->parent_text}}</q></div>
                                        @endif
                                    @endif
                                    <li class="media">
                                        <div class="row-cols-2">
                                            <div class="col-4">
                                                <div class="media-body">
                                                    <div class="media-heading">
                                                        <div class="author">{{$comment->name}}</div>
                                                        <div class="media-text text-justify">{{$comment->title}}</div>
                                                    </div>
                                                    <div class="media-text text-justify"> {{$comment->text}} </div>
                                                    <div class="footer-comment">
                                                        @can('view-protected-part',CommentController::class)
                                                            <form action="" method="post">
                                                                @csrf
                                                                <div class="col-md-8">
                                                                    <div class="mb-3">
                                                                        <input name="title" type="text"  placeholder="Заголовок сообщения" required>
                                                                    </div>
                                                                    <div class="mb-3"><textarea name="text" id="comments" placeholder="Оставьте сообщение!"
                                                                                                required></textarea>
                                                                    </div>
                                                                    <input name="authorId" type="hidden" value="{{ Auth::user()->id }}">
                                                                    <input name="userId" type="hidden" value="{{ $user->id }}">
                                                                    <input name="parent" type="hidden" value="{{ $comment->id }}">
                                                                    <div class="mb-3">
                                                                        <input type="submit" name="send" value="Ответить">
                                                                    </div>
                                                                </div>
                                                            </form>
                                                            @if($comment->permission == '1')
                                                                <form action="" method="post">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <input name="userId" type="hidden" value="{{$user->id}}">
                                                                    <input name="commId" type="hidden" value="{{ $comment->id }}">
                                                                    <input type="submit" name="delete" value="Удалить">
                                                                </form>
                                                            @endif
                                                            @endcan
                                                        </div>
                                                        <hr>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div></div>
                                            </div>
                                        </div>

                                    </li>
                                @endforeach
                            </ul>
                            @if($count > 5)
                                <div id="fun">
                                    <button id="example-1">Click to update</button>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {
                // вешаем на клик по элементу с id = example-1
                $('#example-1').click(function () {
                    $.ajax({
                        type: "GET",
                        // url: '/fetch-comments',
                        url: '{{ route('fetch-comm', ['userId' => $user->id]) }}',
                        datatype: "json",
                        success: function (response) {
                            console.log(response.comments);
                            console.log(response.user.name);

                            $.each(response.comments, function (key, item) {
                                //console.log(item.host_user_id);
                                if (item.parent_id !== "0") {
                                    if (item.parent_text === "") {
                                        $("#commlist").append('<div class="parentText"><q> Комментарий удален</q></div>');
                                    } else {
                                        $("#commlist").append('<div class="parentText"><q>' + item.parent_text + '</q></div>');
                                    }
                                }
                                $("#commlist").append(
                                    '<li class="media">\
                                        <div class="row-cols-2">\
                                            <div class="col-4">\
                                                <div class="media-body">\
                                                    <div class="media-heading">\
                                                    <div class="author">' + item.name + '</div>\
                                                    <div class="media-text text-justify">' + item.title + '</div>\
                                                    </div>\
                                                    <div class="media-text text-justify"> ' + item.text + ' </div>\
                                                    <div class="footer-comment">\
                                                        @can('view-protected-part',CommentController::class)\
                                                        <form action="" method="post">\
                                                        @csrf\
                                                        <div class="col-md-8">\
                                                        <div class="mb-3">\
                                                            <input name="title" type="text" placeholder="Заголовок сообщения" required>\
                                                        </div>\
                                                        <div class="mb-3"><textarea name="text" id="comments" placeholder="Оставьте сообщение!"required></textarea></div>\
                                                        <input name="authorId" type="hidden" value="{{ Auth::user()->id }}">\
                                                            <input name="userId" type="hidden" value="' + response.user.id + '">\
                                                                <input name="parent" type="hidden" value="' + item.id + '">\
                                                                    <div class="mb-3">\
                                                                        <input type="submit" name="send" value="Ответить">\
                                                                    </div>\
                                                        </div>\
                                                        </form>'
                                );
                                if (item.permission === '1') {
                                    $("#commlist").append(
                                        '<form action="" method="post">\
                                            @csrf\
                                            @method('DELETE')\
                                            <input name="userId" type="hidden" value="' + response.user.id + '">\
                                                <input name="commId" type="hidden" value="' + item.id + '">\
                                                    <input type="submit" name="delete" value="Удалить">\
                                        </form>\
                                    @endcan\
                                    </div>\
                                        <hr>\
                                        </div>\
                                    </div>\
                                        <div class="col-3">\
                                            <div ></div>\
                                        </div>\
                                    </div>\
                                    </li>'
                                    );
                                }
                            });
                        }
                    });
                    // загрузку HTML кода из файла example.html
                    $('#example-1').hide();
                })
            });
        </script>

@endsection
