@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <play-quizz quizz-content="{{ $quizz->content }}" quizz-bgm="{{ $quizz->bgm }}" quizz-count="{{ $quizz->number }}" quizz-id="{{ $quizz->id }}"></play-quizz>
    </div>
@endsection
