<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col">
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
                    <div id="send-feedback">{{ sendFeedback }}</div>
                </form>
            </div>
            <users-list :channelSocket="channelSocket" :masterId="masterId"></users-list>
        </div>
    </div>
</template>

<script>

//import {OutputQuizz, OutputQuizzItem} from "../classes/outputQuizz";

import Question from "../components/Question.vue";
import UsersList from "./UsersList";


export default {
    name: "PlayQuizz",
    props: ['quizzContent', 'quizzBgm', 'quizzCount', 'idInstance', 'masterId'],
    components: {
        UsersList,
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
            question: "",
            content: 0,
            questionId: -1,
            sendFeedback: "",
            channelSocket: 0
        }
    },
    beforeMount(){
        this.channelSocket = window.Echo.join('playquizz.' + this.idInstance);

    },
    mounted() {
        this.loadQuizz(this.quizzContent, this.quizzCount, this.idInstance);
        this.initBGM(this.quizzBgm);
        this.channelSocket.listen('NextQuestion', e => {
            this.loadNextQuestion(e.idQuestion);
        });
    },
    methods: {
        reset() {
            this.nbgoodanswers = 0;
            this.nbpoints = 0;
            this.score = 0;
        },
        loadQuizz(text, count, idInstance){
            this.reset();
            this.n = count;
            this.idInstance = idInstance;
            this.content = JSON.parse(this.quizzContent);
            console.log("Corresponding json :" + text);
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

        loadNextQuestion(quest){
            if (quest < this.n)
            {
                this.questionId = quest;
                let that = this;

                axios.get('/getquizzquestion/' + this.idInstance + ',' + quest)
                    .then((response)=>{
                        this.$children[0].loadQuestion(JSON.parse(response.data));
                    })
                    .catch(function (error){
                        if (error.response){
                            // Out of 2xx
                            var errMessage = "Error " + error.response.status + " : " + error.response.data.message;
                            that.sendFeedback = errMessage;
                            console.log(errMessage);
                        }
                        else if (error.request){
                            // No response
                            console.log("Error loading the question");
                        }
                        else {
                            console.log('Unknown error');
                            // Unknow error
                        }
                    });
            }
        },

        sendAnswer(){
            const formData = new FormData();
            formData.append('answer', this.$children[0].fillJson());
            formData.append('idInstance', this.idInstance);
            formData.append('idQuestion', this.questionId);

            let that = this;

            const res = /*await*/ axios.post('registerAnswer', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function (response) {
                // Success
                //that.loadNextQuestion();
                that.sendFeedback = "Answer successfully sent";
            })
            .catch(function (error){
                if (error.response){
                    // Out of 2xx
                    var errMessage = "Error " + error.response.status + " : " + error.response.data.message;
                    that.sendFeedback = errMessage;
                    console.log(errMessage);
                }
                else if (error.request){
                    // No response
                    console.log("Error sending the answer");
                }
                else {
                    console.log('Unknown error');
                    // Unknow error
                }
            });
        }
    }
}
</script>
