@extends('layouts.appvuejs')

@section('app')
<form method="POST" action="{{ route('quizz-api-save') }}">
    @csrf
    <div class="container">
        <edit-quizz></edit-quizz>
    </div>
</form>

@endsection
