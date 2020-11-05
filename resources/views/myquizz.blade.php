@extends('layouts.app')

@section('content')

    <div class="container">
    <?php
    $quizzs = \App\Repositories\QuizzRepository::findByUID();
    ?>

    <h1>My quizz :</h1>
        @forelse ($quizzs as $quizz)

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $quizz->name }}</h5>
                    <p class="card-text">{{ $quizz->content }}</p>

                    <form method="GET" action="/modifyquizz"> 
                        <input type="hidden" name="quizzId" value="{{$quizz->id}}" /> 
                        <input type="submit" value="modify this quizz" >
                    </form>

                    <form method="POST" action="/dropquizz/{{$quizz->id}}">
                        @csrf
                        <input type="submit" value="Delete this quizz"  class="btn btn-danger">
                    </form>
                </div>
            </div><br/>

        @empty
            <div class="alert alert-warning" role="alert">
                You have no quizz yet. <a href="{{ route('quizz-create') }}" class="alert-link">Create one ?</a>
            </div>

        @endforelse
    </div>

@endsection
