<template>
    <div>
        <h1>{{ content.title }}</h1>
        <button v-if="quizzBgm" @click="toggleBGM()" type="button">
            <span v-if="!isAudioPlaying">
                Play background audio
            </span>
            <span v-else>
                Pause background audio
            </span>
        </button>
        <button @click="loadNextQuestion()" type="button">Load question</button>
        <form v-on:submit.prevent="sendAnswer" method="POST" action="/registerAnswer" enctype="multipart/form-data">
            <question></question>
            <button type="submit" class="btn btn-primary"> Send</button>
        </form>

    </div>
</template>

<script>

//import {OutputQuizz, OutputQuizzItem} from "../classes/outputQuizz";

import Question from "../components/Question.vue";


export default {
        name: "PlayQuizz",
        props: ['quizzContent', 'quizzBgm', 'quizzCount', 'quizzId', 'idInstance'],
        components: {
            Question
        },
        data: function(){
            return {
                //quizz: new OutputQuizz(),
                gameFinished: false,
                nbgoodanswers: 0,
                nbpoints: 0,
                score: 0,
                audio: undefined,
                isAudioPlaying: false,
                questionId: 0,
                question: "",
                content: 0
            }
        },
        mounted() {
            this.loadQuizz(this.quizzContent, this.quizzCount, this.quizzId, this.idInstance);
            this.initBGM(this.quizzBgm);
        },
        methods: {
            reset() {
                this.nbgoodanswers = 0;
                this.nbpoints = 0;
                this.score = 0;
            },
            loadQuizz(text, count, quizz_Id, idInstance){
                this.reset();
                this.n = count;
                this.quizz_Id = quizz_Id;
                this.idInstance = idInstance;
                this.content = JSON.parse(this.quizzContent);
                console.log("Corresponding json :" + text);
                //Object.assign(this.quizz, JSON.parse(text));
                //this.quizz.items = this.quizz.items.map((item) => new OutputQuizzItem(item.question, item.answers, item.type));
                //this.quizz.items.forEach(function(item){
                //    item.userChoice = false;
                //});
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

            loadNextQuestion(){
                if (this.questionId < this.n)
                {
                    axios.get('/getquizzquestion/' + this.quizzId + ',' + this.questionId)
                        .then((response)=>{
                            this.$children[0].loadQuestion(JSON.parse(response.data));
                        })
                    this.questionId += 1;
                }
            },

            sendAnswer(){
                const formData = new FormData();
                formData.append('answer', this.$children[0].fillJson());
                formData.append('idInstance', this.idInstance);

                const res = /*await*/ axios.post('registerAnswer', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                // TODO : if ok
                this.loadNextQuestion();
            }
        }
    }
</script>
