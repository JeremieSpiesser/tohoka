@extends('layouts.appvuejs')

@section('app')
    <div class="container">
        <manage-instance id-instance="{{ $id }}" quizz-num="{{ $num }}" master-id={{ $master }}>
        </manage-instance>
    </div>
@endsection
