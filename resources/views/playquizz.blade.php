@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <play-quizz quizz-content="{{ $quizz->content }}" quizz-bgm="{{ $quizz->bgm }}" quizz-count="{{ $quizz->count }}"></play-quizz>
    </div>
@endsection
