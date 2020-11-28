<template>
    <div>
        <h1>{{ quizz.title }}</h1>
        <button v-if="quizzBgm" @click="toggleBGM()" type="button">
            <span v-if="!isAudioPlaying">
                Play background audio
            </span>
            <span v-else>
                Pause background audio
            </span>
        </button>
        <div id="foo"></div>
        <button @click="loadQuestion(18)" type="button">Load question</button>
        <question></question>

    </div>
</template>

<script>

import {OutputQuizz, OutputQuizzItem} from "../classes/outputQuizz";

import Question from "../components/Question.vue";


export default {
        name: "PlayQuizz",
        props: ['quizzContent', 'quizzBgm', 'quizzCount'],
        components: {
            Question
        },
        data: function(){
            return {
                quizz: new OutputQuizz(),
                gameFinished: false,
                nbgoodanswers: 0,
                nbpoints: 0,
                score: 0,
                audio: undefined,
                isAudioPlaying: false,
                questionId: 0,
                n: 0,
                question: ""
            }
        },
        mounted() {
            this.loadQuizz(this.quizzContent, this.quizzCount);
            this.initBGM(this.quizzBgm);
        },
        methods: {
            reset() {
                this.nbgoodanswers = 0;
                this.nbpoints = 0;
                this.score = 0;
            },
            loadQuizz(text, count){
                this.reset();
                this.n = count;
                console.log("Corresponding json :" + text);
                Object.assign(this.quizz, JSON.parse(text));
                this.quizz.items = this.quizz.items.map((item) => new OutputQuizzItem(item.question, item.answers, item.type));
                this.quizz.items.forEach(function(item){
                    item.userChoice = false;
                });
            },
            initBGM(path){
                this.audio = new Audio(path);
                this.audio.loop = true;
                this.audio.volume = 0.15;
            },
            toggleBGM(){
                  if(!this.audio.paused) {
                      this.isAudioPlaying = false;
                      this.audio.pause();
                  }else{
                      this.isAudioPlaying = true;
                      this.audio.play();
                  }
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
                this.score = Math.round((this.nbpoints / this.nbgoodanswers) * 100);
                //this.handleProgressBar();
            },

            loadQuestion(quizzId){
                if (this.questionId < this.n)
                {
                    axios.get('/getquizzquestion/' + quizzId + ',' + this.questionId)
                        .then((response)=>{
                            this.$children[0].loadQuestion(JSON.parse(response.data));
                        })
                    this.questionId += 1;
                }
            }
        }
    }
</script>
