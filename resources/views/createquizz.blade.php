@extends('layouts.app')

@section('custom-js')
    <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="application/javascript" src="{{ asset('InputQuizz.js') }}"></script>
@endsection

@section('content')
<form method="POST" action="/savequizz">
    @csrf
    <div class="container">
        <div id="vue-app">
            <input type="text" name="name" hidden="yes" value="@{{ quizz.getTitle() }}">
            <h1>New Quizz  : @{{ quizz.getTitle() }} </h1>
            <input type="textbox" v-model="quizz.title" />
            <ul>
                <li v-for="item in quizz.items">
                    <h3>@{{ item.getQuestion() }} </h3>
                    <input type="textbox" v-model="item.question" />


                    <ul v-for="(possAnswer,index) in item.getAnswers()">
                        <li>  @{{ index }} : @{{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer" />
                        <input type="checkbox" v-model="possAnswer.bool" placeholder="Correct answer ?" />
                    </ul>
                    <button @click="item.addPossibleAnswer()"> Add an answer </button>
                </li>
            </ul>
            <button v-on:click="quizz.addItem()"> Add item </button>
            <button v-on:click="populateJson()" >Export to JSON </button>
            <input type="text" name="content" hidden="yes" value="@{{ jsonExport }}">
            <p> @{{ jsonExport }}</p>
            <input type="submit" value="Save this quizz."></input>
        </div>
    </div>
</form>

@endsection
