@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <form method="POST" action="{{ route('quizz-api-modify', ['id' => $quizz->id]) }}">
            @csrf
            <edit-quizz quizz-content="{{ $quizz->content }}"></edit-quizz>
        </form>
    </div>
@endsection
