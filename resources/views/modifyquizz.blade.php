@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <form method="POST" action="{{ route('quizz-api-modify', ['id' => $quizz->id]) }}" enctype="multipart/form-data">
            @csrf
            <edit-quizz quizz-content="{{ $quizz->content }}" private="{{ $quizz->private }}"></edit-quizz>
        </form>
    </div>
@endsection
