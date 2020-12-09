@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <form method="POST" action="{{ route('register-to-instance') }}" enctype="multipart/form-data">
            <div class="container">
                <create-instance></create-instance>
            </div>
        </form>
    </div>
@endsection
