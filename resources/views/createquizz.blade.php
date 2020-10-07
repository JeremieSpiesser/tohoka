<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">


    </head>
    <body class="antialiased">
        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
        <script src="{{ URL::asset('Quizz.js') }}" defer></script>

         <div id="app">
                <h1>New Quizz  : @{{ quizz.getTitle() }} </h1>
                <button @click="quizz.addItem()"> Add item </button>
                <ul>
                    <li v-for="item in quizz.items">
                        <h3>@{{ item.getQuestion() }} </h3>
                        <ol v-for="possAnswer in item.getPossibleAnswers()">
                            <li> @{{ possAnswer }} </li>


                        </ol>
                    <button @click="item.addPossibleAnswer()"> </button>

                    </li>


                </ul>

         </div>

    </body>
</html>
