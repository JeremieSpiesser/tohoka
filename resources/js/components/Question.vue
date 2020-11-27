<template>
    <div>
        <ul>
            <h3>question.title</h3>
            <div v-if='question.type === "qcm" || question.type === "qcma"'>
                <ul v-for="(possAnswer,index) in question.answers">
                    <li>
                        <input type="checkbox" v-model="possAnswer.index">
                        {{ possAnswer }}
                    </li>
                </ul>
            </div>
            <div v-if="question.type === 'classic'">
                <h4>Only one answer is possible here !</h4>
                <ul v-for="(possAnswer, index) in question.answers">
                    <li>
                        <!--input type="checkbox" v-model="possAnswer.userChoice" @click="item.disableOthers(possAnswer)"-->
                        <input type="radio" v-model="question.userUniqueChoice" :value="possAnswer.answer">{{ possAnswer.answer }}</input>
                    </li>
                </ul>

            </div>
            <div v-if="question.type === 'tf'">
                <input type="radio" v-model="question.userTfChoice" value="true">Vrai</input>
                <input type="radio" v-model="question.userTfChoice" value="false">Faux</input>
            </div>
        </ul>

        <button type="button" class="btn btn-primary" @click="sendAnswers()"> Send the answers </button>
    </div>
</template>

<script>

//import {QuizzQuestion} from "../classes/quizzQuestion";

export default {
        name: "Question",
        props: ['quizzQuestion'],
        data: function(){
            return {
                question: 0
            }
        },
        mounted() {
            this.loadQuestion(this.quizzQuestion);
        },
        methods: {
            loadQuestion(json){
                this.question = JSON.parse(json);
                //alert(this.question.type);
            },

            loadQuestion(quizzId, questionId){
                axios.get('/getquizzquestion/18,1')
                    .then((response)=>{
                        document.getElementById("vuequestion").innerHTML = response.data;
                        //document.getElementById("vuequestion").innerHTML = "<b>Coucou</b>";
                        //this.question = response.data;
                    })
            }
        }
    }
</script>
