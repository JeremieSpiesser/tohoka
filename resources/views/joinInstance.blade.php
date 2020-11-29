@extends('layouts.appvuejs')

@section('app')
<form method="POST" action="{{ route('register-to-instance') }}" enctype="multipart/form-data">
    @csrf
    <div class="container">
        <join-instance></join-instance>
    </div>
</form>
@endsection
