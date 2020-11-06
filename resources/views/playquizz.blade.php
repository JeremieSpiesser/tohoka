@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <play-quizz quizz-content="{{ $quizz->content }}"></play-quizz>
    </div>
@endsection
