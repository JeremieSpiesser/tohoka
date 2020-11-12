<template>
    <div>
        <h1>Quizz : {{ quizz.title }}</h1>
        <input type="textbox" name="name" v-model="quizz.title" />
        <ul>
            <li v-for="(item,ind) in quizz.items">
                <h3>{{ item.question }} </h3>
                <input type="textbox" v-model="item.question" />
                <input type="button" value="Delete" 			@click="quizz.removeItemAt(ind)">
          
                
                <select v-model="item.type">
                    <option value="qcm">QCM sans avertissement</option>
                    <option value="classic">Question à réponse unique</option>
                    <option value="qcma">QCM avec avertissement</option>
                    <option value="tf">Vrai/Faux</option>
                </select>

                <div v-if="item.type === 'classic'">
                    <ul v-for="(possAnswer,index) in item.answers">
              
                        <li>  {{ index }} : {{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer" /> 
                        <input type="button" value="Delete" @click="item.removeItemAt(index)"/>
                        Vrai ? <input type="checkbox" v-model="possAnswer.bool" @click="item.disableOthers(possAnswer)" placeholder="Correct answer ?" />  
		</ul>
                    <button type="button" @click="item.addPossibleAnswer()"> Add an answer </button>

                </div>

                <div v-if="item.type === 'tf'">
                    <input type="radio" value=true v-model="item.isTrue">Vrai</input>
                    <input type="radio" value=false v-model="item.isTrue">Faux</input>
                </div>
                <div v-if="item.type.includes('qcm')">
                    <ul v-for="(possAnswer,index) in item.answers">
                        <li>  {{ index }} : {{ possAnswer.answer }} </li> : <input type="textbox" v-model="possAnswer.answer" />
                                                   <input type="button" value="Delete" @click="item.removeItemAt(index)"/>
                        Vrai ? <input type="checkbox" v-model="possAnswer.bool" placeholder="Correct answer ?" />

                    </ul>
                    <button type="button" @click="item.addPossibleAnswer()"> Add an answer </button>
                </div>
            </li>
        </ul>
        <button type="button" v-on:click="quizz.addItem()"> Add item </button>
        <button type="button" v-on:click="populateJson()" >Export to JSON </button>
        <input v-model="jsonExport" name="content" hidden="yes" />
        <p> {{ jsonExport }}</p>
        <input v-on:click="populateJson()" type="submit" value="Save this quizz."/>
    </div>
</template>

<script>

import {InputQuizz, InputQuizzItem} from '../classes/inputQuizz';

export default {
    name: "EditQuizz",
    props: ['quizzContent'],
    data: function () {
        return {
            quizz: new InputQuizz("Sample quizz"),
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
