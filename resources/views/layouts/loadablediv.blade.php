@section('__vuejs')
    <!-- Scripts-->
    <script src="{{ asset('js/vueLoad.js') }}" defer></script>
@endsection

@section('content')
    @yield('app')
@endsection
