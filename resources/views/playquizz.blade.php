@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <play-quizz quizz-content="{{ $quizz->content }}" quizz-bgm="{{ $quizz->bgm }}"></play-quizz>
    </div>
@endsection
