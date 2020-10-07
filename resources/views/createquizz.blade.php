<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


    </head>
    <body class="antialiased">
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="{{ URL::asset('InputQuizz.js') }}" defer></script>

         <div id="app">
                <h1>New Quizz  : @{{ quizz.getTitle() }} </h1>
                <button @click="quizz.addItem()"> Add item </button>
                <ul>
                    <li v-for="item in quizz.items">
                        <h3>@{{ item.getQuestion() }} </h3>
                        <ul v-for="(possAnswer,index) in item.getAnswers()">
                            <li>  @{{ index }} : @{{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer"> </input>
                            <input type="checkbox" v-model="possAnswer.bool">Correct answer ? </input>
                        </ul>
                    <button @click="item.addPossibleAnswer()"> Add an answer </button>
                    </li>
                </ul>
                <button @click="quizz.toJson()" >Export to JSON </button>
         </div>

    </body>
</html>
