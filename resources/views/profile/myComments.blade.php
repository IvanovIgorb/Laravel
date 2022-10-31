@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"> Добро пожаловать на стену  </div>

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
                                        <input name="userId" type="hidden" value="">
                                        <div class="mb-3"><input type="submit" value="Отправить"></div>
                                    </div>
                                </div>
                            </form>
                            @endcan

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
