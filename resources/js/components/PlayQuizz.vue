<template>
    <div>
        <h1>{{ quizz.title }}</h1>
        <ul>
            <li v-for="item in quizz.items">
                <h3  v-if="gameFinished" class="alert alert-primary" role="alert">
                    {{ item.question }}<div style="text-align:right;font-style: italic;">Score : {{ item.score }}/{{ item.getNbGoodAnswers() }}</div></h3>
                <h3  v-else>{{ item.question }} </h3>
                <div v-if='item.type.includes("qcm")'>
                    <h4 v-if="item.type === 'qcma' && gameFinished">Multiple answers are possible here !</h4>
                    <ul v-for="(possAnswer,index) in item.answers">
                        <li>{{ index }} : {{ possAnswer.answer }}
                            <input type="checkbox" v-model="possAnswer.userChoice">
                            <div v-if="gameFinished">
                                <p v-if="possAnswer.userChoice && (possAnswer.userChoice === possAnswer.bool)" style="color:green"> Bravo :) </p>

                                <p v-else-if="possAnswer.userChoice && !(possAnswer.userChoice === possAnswer.bool)" style="color:red"> C'est FAUX :( </p>
                                <p v-else-if="!possAnswer.userChoice && possAnswer.bool"> Il fallait cliquer ici, dommage :/ </p>

                                <p v-if="!possAnswer.bool && !possAnswer.userChoice"></p>
                            </div>
                        </li>
                    </ul>
                </div>
                <div v-if="item.type === 'classic'">
                    <h4>Only one answer is possible here !</h4>
                    <ul v-for="(possAnswer, index) in item.answers">
                        <li>
                            <!--input type="checkbox" v-model="possAnswer.userChoice" @click="item.disableOthers(possAnswer)"-->
                            <input type="radio" v-model="item.userUniqueChoice" :value="possAnswer.answer">{{ possAnswer.answer }}</input>

                            <div v-if="gameFinished">
                                <!-- Si coché et ok -  nice
                                sinon si pas coché et ok - not nice
                                si coché et pas ok - not nice -->
                                <p v-if="(item.userUniqueChoice === possAnswer.answer) && (possAnswer.bool)" style="color:green">Bravo :) </p>
                                <p v-else-if="(item.userUniqueChoice === possAnswer.answer) && (!possAnswer.bool)" style="color:red"> Faux :( </p>
                                <p v-if="(item.userUniqueChoice !== possAnswer.answer) && possAnswer.bool"> Il fallait cliquer ici, dommage :/</p>
                            </div>
                        </li>
                    </ul>

                </div>
                <div v-if="item.type === 'tf'">
                    <input type="radio" v-model="item.userTfChoice" value="true">Vrai</input>
                    <input type="radio" v-model="item.userTfChoice" value="false">Faux</input>
                    <div v-if="gameFinished">
                        <p v-if="item.userTfChoice === item.isTrue" style="color:green">Bravo :)</p>
                        <p v-if="item.userTfChoice !== item.isTrue" style="color:red">C'est Faux :(</p>
                    </div>
                </div>
            </li>
        </ul>

        <button type="button" class="btn btn-primary" v-if="!gameFinished" @click="toggleFinished()"> Show answers </button>

        <div class="jumbotron" v-if="gameFinished" style="background-color:#ffc107; color:white;">
            <div class="container">
                <h1 class="display-4">Congratulations, you've got {{ nbpoints }}/{{ nbgoodanswers }} !</h1>
                <div class="progress">
                    <div id="achievement" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">{{ score }}%</div>
                </div><br/>
                <hr>
                <div class="row justify-content-center">
                    <button type="button" class="d-flex justify-content-center btn btn-danger" @click="toggleFinished()"> Hide answers </button>
                </div>
            </div>
        </div>

    <audio id="BGM">
        <source :src="quizz.backgroundAudio" type="audio/ogg">
        Your browser does not support the audio element.
    </audio>
    <button onclick="playBGM()" type="button">Play Audio</button>

    </div>
</template>

<script>

var audioElement = document.getElementById("BGM"); 

function playBGM() { 
  audioElement.play(); 
}

import {OutputQuizz, OutputQuizzItem} from "../classes/outputQuizz";

export default {
        name: "PlayQuizz",
        props: ['quizzContent'],
        data: function(){
            return {
                quizz: new OutputQuizz(),
                gameFinished: false,
                nbgoodanswers: 0,
                nbpoints: 0,
                score: 0
            }
        },
        mounted() {
            this.loadQuizz(this.quizzContent);
        },
        methods: {
            reset() {
                this.nbgoodanswers = 0;
                this.nbpoints = 0;
                this.score = 0;
            },
            loadQuizz(text){
                this.reset();
                console.log("Corresponding json :" + text);
                Object.assign(this.quizz, JSON.parse(text));
                this.quizz.items = this.quizz.items.map((item) => new OutputQuizzItem(item.question, item.answers, item.type));
                this.quizz.items.forEach(function(item){
                    item.userChoice = false;
                });
            },
            /*handleProgressBar(){
                var progress = document.getElementById("achievement");
                progress.focus();
                progress.style.width = this.score + "%";
                //progress.aria-valuenow = this.score;

            },*/
            toggleFinished() {
                console.log(this.nbpoints);
                this.reset();
                document.querySelectorAll('input[type=checkbox]').forEach((checkbox) => {
                    checkbox.disabled = !checkbox.disabled;
                })
                this.gameFinished = !this.gameFinished;
                for (const item of this.quizz.items) {
                    item.computeScore();
                    this.nbpoints += item.score;
                    this.nbgoodanswers += item.getNbGoodAnswers();
                }
                this.score = (this.nbpoints / this.nbgoodanswers) * 100;
                //this.handleProgressBar();
            }
        }
    }
</script>
