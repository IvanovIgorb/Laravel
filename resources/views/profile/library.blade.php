@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Добро пожаловать в библиотеку {{ $user->name }}</div>
                    <div class="card-body">
                        @if(\Illuminate\Support\Facades\Auth::id() == $user->id)
                        <div class="row">
                            <div class="col-3" align="center"> <button class="btn btn-primary"
                                                                       onClick='location.href="{{
    route('profile.createBook', ['userId' => Auth::user()->id])
    }}"'>
                                    Добавить книгу </button> </div>

                        </div>
                        <hr>
                        @endif
                        <div class="row">
                            <ul class="media-list">
                                @foreach ($books as $book)
                                    <li class="media">
                                        <div class="media-body">
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col-3"> {{$book->name}} </div>
                                                    <div class="col-2" align="center"> <button class="btn btn-primary"
                                                                                               onClick='location.href="{{
    route('profile.readBook', ['userId' => $user->id, 'bookId' => $book->id])
    }}"'>
                                                            Читать</button>
                                                    </div>
                                                    @if(\Illuminate\Support\Facades\Auth::id() == $user->id)
                                                    <div class="col-2" align="center"> <button class="btn btn-secondary"
                                                                                               onClick='location.href="{{
    route('profile.editBook', ['userId' => Auth::user()->id, 'bookId' => $book->id])
    }}"'>
                                                            Редактировать</button>
                                                    </div>
                                                    <div class="col-2" align="center">
                                                        <form action="" method="post">
                                                            @csrf
                                                            @method('DELETE')
                                                            <input type="hidden" name="id" value="{{$book->id}}">
                                                            <button class="btn btn-danger" type="submit">Удалить </button>

                                                        </form>
                                                    </div>
                                                    @if($book->access == 0)
                                                    <div class="col-3" align="center">
                                                        <form action="" method="post">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="id" value="{{$book->id}}">
                                                            <input type="submit" name="accessUpdateToY" value="Поделиться со всеми">
                                                        </form>
                                                    </div>
                                                    @elseif($book->access == 1)
                                                        <div class="col-3" align="center">
                                                            <form action="" method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" name="id" value="{{$book->id}}">
                                                                <input type="submit" name="accessUpdateToN" value="Сделать приватной">
                                                            </form>
                                                        </div>
                                                    @endif
                                                    @endif
                                            </div>
                                            <hr>
                                        </div>
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
