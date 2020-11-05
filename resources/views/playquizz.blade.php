@extends('layouts.app')

@section('custom-js')
    <script type="application/javascript" src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="application/javascript" src="{{ asset('OutputQuizz.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div id="playQuizz">
            <h1> Play a quizz here </h1>
            <p> Enter your json backup here (will disappear when quizz will be load from the DB) :</p>
            <textarea id="userBackup" rows="10" cols="50">


            </textarea>
            <br/>
            <button @click="loadQuizz">Let's play !</button>
            <h1>@{{ quizz.getTitle() }}</h1>
            <ul>
                <li v-for="item in quizz.items">
                    <h3>@{{ item.getQuestion() }} </h3>
                    <div v-if='item.type.includes("qcm")'>
                    <h4 v-if="item.type == 'qcma'">Multiple answers are possible here !</h4>
                    <ul v-for="(possAnswer,index) in item.getAnswers()">
                        <li>@{{ index }} : @{{ possAnswer.answer }}
                            <input type="checkbox" v-model="possAnswer.userChoice">
                            <div v-if="gameFinished">
                                <p v-if="possAnswer.userChoice && (possAnswer.userChoice === possAnswer.bool)" style="color:green"> Bravo :) </p>
                                <p v-else-if="possAnswer.userChoice && (possAnswer.userChoice != possAnswer.bool)" style="color:red"> C'est FAUX :( </p>
                                <p v-else-if="!possAnswer.userChoice && possAnswer.bool"> Il fallait cliquer ici, dommage :/ <p>
                                <p v-if="!possAnswer.bool && !possAnswer.userChoice">
                            </div>
                        </li>
                    </ul>
                    </div>
                    <div v-if="item.type === 'classic'">
                    <h4>Only one answer is possible here !</h4>
                    <ul v-for="(possAnswer,index) in item.getAnswers()">
                        <li>
                            <!--input type="checkbox" v-model="possAnswer.userChoice" @click="item.disableOthers(possAnswer)"-->
                            <input type="radio" v-model="item.userUniqueChoice" :value="possAnswer.answer">@{{possAnswer.answer}}</input>

                            <div v-if="gameFinished">
        <!-- Si coché et ok -  nice
        sinon si pas coché et ok - not nice
        si coché et pas ok - not nice -->
                                <p v-if="(item.userUniqueChoice === possAnswer.answer) && (possAnswer.bool)" style="color:green">Bravo :) </p>
                                <p v-else-if="(item.userUniqueChoice === possAnswer.answer) && (!possAnswer.bool)" style="color:red"> Faux :( </p>
                                <p v-if="(item.userUniqueChoice != possAnswer.answer) && possAnswer.bool"> Il fallait cliquer ici, dommage :/</p>
                            </div>
                        </li>
                    </ul>
                    
                    </div>
                    <div v-if="item.type === 'tf'">
                        <input type="radio" v-model="item.userTfChoice" value="true">Vrai</input>
                        <input type="radio" v-model="item.userTfChoice" value="false">Faux</input>
                        <div v-if="gameFinished">
                            <p v-if="item.userTfChoice === item.isTrue" style="color:green">Bravo :)</p>
                            <p v-if="item.userTfChoice != item.isTrue" style="color:red">C'est Faux :(</p>
                        </div>
                    </div>
                </li>
            </ul>

            <button @click="toggleFinished()">
                <div v-if="gameFinished"> Hide answers </div>
                <div v-else> Show answers </div>
            </button>

        </div>
    </div>
@endsection
