@extends('layouts.app')

@section('custom-js')
    <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="application/javascript" src="{{ asset('InputQuizz.js') }}"></script>
@endsection
@section('content')

<?php $id=$_GET['quizzId'];
$cont=DB::select('select content from quizzs where id = :id',['id'=>$id]);
$quizzContent=$cont[0]->content;
echo "<script type='application/javascript' defer> var chaine = '$quizzContent' </script> ";
?>


<form method="POST" action="/modQuizz">
    @csrf
    <div class="container">
        <div id="vue-app">
            <h1>New Quizz  : @{{ quizz.getTitle() }} </h1>
            <input type="textbox" name="name" v-model="quizz.title" />
            <ul>
                <li v-for="item in quizz.items">
                    <h3>@{{ item.getQuestion() }} </h3>
                    <input type="textbox" v-model="item.question" />


                    <ul v-for="(possAnswer,index) in item.getAnswers()">
                        <li>  @{{ index }} : @{{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer" />
                        <input type="checkbox" v-model="possAnswer.bool" placeholder="Correct answer ?" />
                    </ul>
                    <button type="button" @click="item.addPossibleAnswer()"> Add an answer </button>
                </li>
            </ul>
            <button type="button" v-on:click="quizz.addItem()"> Add item </button>
            <button type="button" v-on:click="populateJson()" >Export to JSON </button>
            <input v-model="jsonExport" name="content" hidden="yes">
            <?php echo "<input type='hidden' name='id' value=$id />" ?>
            <p> @{{ jsonExport }}</p>
            <input v-on:click="populateJson()" type="submit" value="Save this quizz."></input>
        </div>
    </div>
    </form>


@endsection
