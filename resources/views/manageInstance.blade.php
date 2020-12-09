@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <manage-instance id-instance="{{ $id }}" master-id={{ $master }}>
        </manage-instance>
    </div>
@endsection
