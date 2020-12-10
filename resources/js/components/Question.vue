<template>
    <div>
        <ul>
            <h3>{{ question.question }}</h3>
            <div v-if='question.imageUrl !== ""'>
                <img :src="question.imageUrl">
            </div>
            <button v-if="this.question.audioUrl !== ''" @click="toggleAudio()" type="button">
        <span v-if="!isAudioPlaying">
            Play background audio
        </span>
        <span v-else>
            Pause background audio
        </span>
            </button>
            <div v-if='question.type === "qcm" || question.type === "qcma"'>
                <ul v-for="(possAnswer,index) in question.answers">
                    <li>
                        <input type="checkbox" v-model="userChoice[index]">
                        {{ possAnswer }}
                    </li>
                </ul>
            </div>
            <div v-if="question.type === 'classic'">
                <h4>Only one answer is possible here !</h4>
                <ul v-for="(possAnswer, index) in question.answers">
                    <li>
                        <!--input type="checkbox" v-model="possAnswer.userChoice" @click="item.disableOthers(possAnswer)"-->
                        <input type="radio" v-model="userChoice[0]" :value="index">{{ possAnswer }}</input>
                    </li>
                </ul>

            </div>
            <div v-if="question.type === 'tf'">
                <input type="radio" v-model="userChoice[0]" v-bind:value="true">Vrai</input>
                <input type="radio" v-model="userChoice[0]" v-bind:value="false">Faux</input>
            </div>
        </ul>
    {{ userChoice }}
    </div>
</template>

<script>

//import {QuizzQuestion} from "../classes/quizzQuestion";

export default {
        name: "Question",
        props: ['quizzQuestion'],
        data: function(){
            return {
                question: 0,
                userChoice: [],
                answer: "",
                audio: undefined,
                isAudioPlaying: false
            }
        },
        mounted() {
            //this.loadQuestion(this.quizzQuestion);
        },
        methods: {
            loadQuestion(json){
                this.userChoice = []
                this.question = json;
                if (this.question.audioUrl !== ''){
                    this.audio = new Audio(this.question.audioUrl);
                    this.audio.loop = true;
                    this.audio.volume = 0.25;
                }
            },

            toggleAudio(){
                  if(!this.audio.paused) {
                      this.isAudioPlaying = false;
                      this.audio.pause();
                  }else{
                      this.isAudioPlaying = true;
                      this.audio.play();
                  }
            },

            fillJson(){
                return JSON.stringify(this.userChoice);
            }
        }
    }
</script>
