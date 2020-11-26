<template>
    <div> 
        <head>
            <link rel = "stylesheet" href = "~/Desktop/ENSIIE/PIMA/project/pima-groupe4-2020-tohoka/resources/sass/app.scss">
        </head>

        
        <h1 class="display-2" id = "Head">Quizz: {{ quizz.title }}</h1>
        <input type="textbox" name="name" id ="QuizTitle" placeholder="Nom du Quizz" v-model="quizz.title" />
        <ul>
            <li id="Questionnaire" v-for="(item,ind) in quizz.items">
                
                <h3>{{ item.question }} </h3>
                
                <form class="form-inline">
                <div class="form-row align-items-center">
                    <input type="textbox" v-model="item.question" />            
                    <input type="button"  class="btn btn-outline-danger" value="Delete." 	@click="quizz.removeItemAt(ind)">            
                    <label class="mr-sm-2 sr-only" for="inlineFormCustomSelect">Preference</label>
                    <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" v-model="item.type">
                        <option value="qcm">QCM sans avertissement</option>
                        <option value="classic">Question à réponse unique</option>
                        <option value="qcma">QCM avec avertissement</option>
                        <option value="tf">Vrai/Faux</option>
                    </select>
                </div>
                </form>
                <div v-if="item.type === 'classic'">
                    <ul v-for="(possAnswer,index) in item.answers">
              
                        <li>  {{ index }} : {{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer" /> 
                        <input type="button"  class="btn btn-outline-danger btn-sm"value="Delete" @click="item.removeItemAt(index)"/>
                        Vrai ? <input type="checkbox" v-model="possAnswer.bool" @click="item.disableOthers(possAnswer)" placeholder="Correct answer ?" />  
		            </ul>
                    <button type="button"  class="btn btn-outline-success btn-sm" @click="item.addPossibleAnswer()" > Add an answer </button>
                </div>

                <div v-if="item.type === 'tf'">
                    <input type="radio" value=true v-model="item.isTrue">Vrai</input>
                    <input type="radio" value=false v-model="item.isTrue">Faux</input>
                </div>
                <div v-if="item.type.includes('qcm')">
                    <ul v-for="(possAnswer,index) in item.answers">
                        <li>  {{ index }} : {{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer" />
                                                   <input type="button" class="btn btn-outline-danger btn-sm" data-toggle="button" aria-pressed="false" value="Delete" @click="item.removeItemAt(index)"/>
                        Vrai ? <input type="checkbox" v-model="possAnswer.bool" placeholder="Correct answer ?" />

                    </ul>
                    <button type="button" class="btn btn-outline-success "  @click="item.addPossibleAnswer()"> Add an answer </button>
                </div>
            </li>
        </ul>
        <button type="button" class="btn btn-outline-info" aria-pressed="false "  v-on:click="quizz.addItem()"> Add item </button>
        <button type="button" class="btn btn-outline-info" data-toggle="button " aria-pressed="false" v-on:click="populateJson()" >Export to JSON </button>
        <input v-model="jsonExport" name="content" hidden="yes" >
        <p> {{ jsonExport }}</p>
        <input class="btn btn-secondary" v-on:click="populateJson()" type="submit" value="Save this quizz."/>
    </div>
</template>

<script>

import {InputQuizz, InputQuizzItem} from '../classes/inputQuizz';

export default {
    name: "EditQuizz",
    props: ['quizzContent'],
    data: function () {
        return {
            quizz: new InputQuizz("Sample Quiz."),
            jsonExport: ""
        }
    },
    mounted: function(){
        if(this.quizzContent !== undefined){
            this.loadQuizz(this.quizzContent);
        }else{
            this.quizz.addItem()
        }
    },
    methods: {
        populateJson(){
            this.jsonExport = this.quizz.toJson();
        },
        loadQuizz(text){
            let serializedObject = JSON.parse(text);
            Object.assign(this.quizz, serializedObject);
            this.quizz.items = this.quizz.items.map((item) => new InputQuizzItem(item.question, item.answers, item.type));
        }
    }
}


</script>
