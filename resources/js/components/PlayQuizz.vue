<template>
    <div class="container-fluid">
        <div v-if="gameStarted" class="row pt-3 pb-4">
            <timer :on-complete="hideQuestion" :timeout="timeout"></timer>
        </div>
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

                <form v-bind:class="{'d-none' : timeout || !gameStarted}" v-on:submit.prevent="sendAnswer" method="POST" action="/registerAnswer" enctype="multipart/form-data">
                    <question ref="questRef"></question>
                    <button type="submit" class="btn btn-primary"> Send</button>
                    <div id="send-feedback">{{ sendFeedback }}</div>
                </form>
                <span v-if="timeout && gameStarted">Temps écoulé !</span>
                <span v-if="!gameStarted">Attendez que l'animateur démarre la partie</span>
            </div>
            <div class="col">
                <users-list :channelSocket="channelSocket" :masterId="masterId"></users-list>
            </div>
        </div>
    </div>
</template>

<script>

//import {OutputQuizz, OutputQuizzItem} from "../classes/outputQuizz";

import Question from "../components/Question.vue";
import UsersList from "./UsersList";
import Timer from "./Timer";


export default {
    name: "PlayQuizz",
    props: ['quizzContent', 'quizzBgm', 'quizzCount', 'idInstance', 'masterId'],
    components: {
        Question,
        Timer,
        UsersList
    },
    data: function(){
        return {
            audio: undefined,
            isAudioPlaying: false,
            content: 0,
            questionId: -1,
            sendFeedback: "",
            channelSocket: 0,
            timeout: false,

            gameStarted: false
        }
    },
    beforeMount(){
        this.channelSocket = window.Echo.join('playquizz.' + this.idInstance);

    },
    mounted() {
        this.initBGM(this.quizzBgm);
        this.channelSocket.listen('NextQuestion', e => {
            this.gameStarted = true;
            this.loadNextQuestion(e.idQuestion);
        });
    },
    methods: {
        hideQuestion(){
            this.timeout = true;
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
            if (quest < this.quizzCount)
            {
                this.questionId = quest;
                this.timeout = false;
                this.$refs.questRef.loadQuestion({});
                let that = this;

                axios.get('/getquizzquestion/' + this.idInstance + ',' + quest)
                    .then((response)=>{

                        this.$refs.questRef.loadQuestion(JSON.parse(response.data));

                        axios.get('/state/load/' + this.questionId)
                            .then(resp => {

                            })
                            .catch(err => {
                                console.log(err);
                            });
                    })
                    /*.catch(function (error){
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
                    })*/;
            }
        },

        sendAnswer(){
            const formData = new FormData();
            formData.append('answer', this.$refs.questRef.fillJson());
            formData.append('idInstance', this.idInstance);
            formData.append('idQuestion', this.questionId);

            let that = this;

            const res = /*await*/ axios.post('/registerAnswer', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then((response) => {
                // Success
                //that.loadNextQuestion();
                that.sendFeedback = "Answer successfully sent";
                axios.get('/state/finish/' + this.questionId)
                    .then(resp => {

                    })
                    .catch(err => {
                        console.log(err);
                    });
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
