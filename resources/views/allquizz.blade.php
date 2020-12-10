@extends('layouts.app')

@section('content')
    <div class="container">
    <h1>Quizzs publics :</h1>
        @forelse ($quizzs as $quizz)
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $quizz->name }}</h5>
                    <p class="card-text">{{ $quizz->content }}</p>

                    <a class="btn btn-success" href="{{ route('quizz-play', ['id' => $quizz->id]) }}">
                        Play this quizz
                    </a>
                    <a class="btn btn-success" href="{{ route('create-instance', ['id' => $quizz->id]) }}">
                        Create instance
                    </a>
                </div>
            </div><br/>

        @empty
            <div class="alert alert-warning" role="alert">
                There is currently no quizzs. <a href="{{ route('quizz-create') }}" class="alert-link">Create one ?</a>
            </div>

        @endforelse
    </div>

@endsection
