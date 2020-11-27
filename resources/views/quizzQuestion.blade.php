@extends('layouts.loadablediv')

@section('app')
<div class="container">
    <form method="POST" action="{{ route('quizz-submit-question') }}" enctype="multipart/form-data">
        @csrf
        <disp-question quizz-question="{{ $question }}"></disp-question>
    </form>
</div>
@endsection
