@extends('layouts.app')

@section('content')
    <div class="container">
        <div id="carouselContent" class="carousel slide" data-ride="carousel" style="width:100%; color:white; margin-bottom: 30px">
            <ol class="carousel-indicators">
                <li data-target="#carouselContent" data-slide-to="0" class="active"></li>
                <li data-target="#carouselContent" data-slide-to="1"></li>
                <li data-target="#carouselContent" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner" style="height:150px;background-color: #0c5460;">
                <div class="carousel-item active text-center p-4">
                    <h2>Create your own quizz for FREE.</h2>
                    <p>You don't need to pay anything to use our website. To create your own quizz, you juste need to register !</p>
                </div>
                <div class="carousel-item text-center p-4" style="height:150px;background-color: #d39e00">
                    <h2>Challenge yourself on your quizz !</h2>
                    <p>You can easily play one of your quizz, get the correction and your final mark. An easy way to train yourself.</p>
                </div>
                <div class="carousel-item text-center p-4" style="height:150px;background-color: #cc2255">
                    <h2>Compete with other player !</h2>
                    <p>[Coming soon]</p>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselContent" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselContent" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>


            @guest
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>
                <div class="card-body text-center">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    {{ __('You are a guest!') }}
                        <p><br/><a href="{{ route('login') }}" class="btn btn-primary">Log in</a>
                            <a href="{{ route('register') }}" class="btn btn-outline-info">Register</a></p>
                </div>
            </div>
            @endguest

            @auth

            <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Create a new quizz</h5>
                                <a href="{{ route('quizz-create') }}" class="btn btn-primary">Let's create !</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Get the list of your own quizzs</h5>
                                <a href="{{ route('user-quizz') }}" class="btn btn-primary">Show me !</a>
                            </div>
                        </div>
                    </div>
                <div class="col-sm-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Play other user's quizzs</h5>
                            <a href="#" class="btn btn-warning">Coming soon ...</a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Access a specific user's room</h5>
                            <a href="#" class="btn btn-warning">Coming soon ...</a>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </div>
@endsection
