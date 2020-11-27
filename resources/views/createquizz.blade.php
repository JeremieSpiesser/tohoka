@extends('layouts.loadablediv')

@section('content')
<form method="POST" action="{{ route('quizz-api-save') }}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <edit-quizz></edit-quizz>
    </div>
</form>
@endsection
