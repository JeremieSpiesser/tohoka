@extends('layouts.app')

@section('__vuejs')
    <!-- Scripts-->
    <script src="{{ asset('js/vueLoad.js') }}" defer></script>
@endsection

@section('content')
    <div id="vueroot">
        @yield('app')
    </div>
@endsection

@section('custom-js')
@endsection
