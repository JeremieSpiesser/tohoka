@extends('layouts.app')

@section('content')
    <div class="container">
    <h1 class="display-3">My quizzes:</h1>
        @forelse ($quizzs as $quizz)
            <div class="card">
                <div class="card-body">
                    <h5  class="card-title">{{ $quizz->name }}</h5>
                    <p class="card-text">{{ $quizz->content }}</p>

                    <a class="btn btn-outline-success" href="{{ route('quizz-play', ['id' => $quizz->id]) }}">
                        Play this quizz
                    </a>

                    <a class="btn btn-outline-info" href="{{ route('quizz-modify', ['id' => $quizz->id]) }}">
                        Edit this quizz
                    </a>

                    <a class="btn btn-outline-danger" href="{{ route('quizz-api-drop', ['id' => $quizz->id]) }}">
                        Delete this quizz
                    </a>
                </div>
            </div><br/>

        @empty
            <div class="alert alert-warning" role="alert">
                You have no quizzes yet. <a href="{{ route('quizz-create') }}" class="alert-link"> Would you like to create one ?</a>
            </div>

        @endforelse
    </div>

@endsection
