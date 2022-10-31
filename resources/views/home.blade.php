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
                                @foreach ($users as $user)
                                    <li class="media">
                                        <div class="media-body">
                                            <div>
                                                <a href="{{route('profile.index', ['username' => $user->id])}}">
                                                    {{$user->name}}
                                                </a>  </div>
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
