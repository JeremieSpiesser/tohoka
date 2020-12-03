<template>
    <div>
        <ul>
            <h3>{{ question.question }}</h3>
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
                <input type="radio" v-model="userChoice[0]" value="true">Vrai</input>
                <input type="radio" v-model="userChoice[0]" value="false">Faux</input>
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
                answer: ""
            }
        },
        mounted() {
            //this.loadQuestion(this.quizzQuestion);
        },
        methods: {
            loadQuestion(json){
                this.userChoice = []
                this.question = json;
            },

            fillJson(){
                return JSON.stringify(this.userChoice); // TODO : get the results and build the json
            }
        }
    }
</script>
