@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <manage-instance id-instance="{{ $id }}">
        </manage-instance>
    </div>
@endsection
