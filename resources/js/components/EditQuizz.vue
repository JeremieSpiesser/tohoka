<template>
    <div>
        <h1 class="display-2" id = "Head">Quizz: {{ quizz.title }}</h1>
        <input type="textbox" name="name" id ="QuizTitle" placeholder="Nom du Quizz" v-model="quizz.title" />

        <select v-model="private" name="private">
            <option value="0">Privé</option>
            <option value="1">Connecté</option>
            <option value="2">Public</option>
        </select>

        <div class="input-group">
            <div class="custom-file">
                <input type="file" name="bgm" class="custom-file-input" id="inputFileUload"
                v-on:change="onFileChange">
                <label class="custom-file-label" for="inputFileUpload">Choose a background music</label>
            </div>
        </div>
        <br>
        <p class="text-danger font-weight-bold">{{filename}}</p>

        <ul>
            <li id="Questionnaire" v-for="(item,ind) in quizz.items">
                <h3>{{ item.question }} </h3>
                <p>Insert a picture if relevant </p>
                <input type="file" ref="file"><input type="button" value="Upload" @click="uploadFile(ind, 0)">
                <input type="file" ref="file"><input type="button" value="Upload" @click="uploadFile(ind, 1)">
                <input type="textbox" v-model="item.question" />
                <input type="button" value="Delete" 			@click="quizz.removeItemAt(ind)">

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

                        <li>  {{ index }} : {{ possAnswer.answer }} </li>  <input type="textbox" v-model="possAnswer.answer" />
                        <input type="button" class="btn btn-outline-danger btn-sm" value="Delete" @click="item.removeItemAt(index)"/>
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
        <input class="btn btn-secondary" v-on:click="populateJson()" name="submit" type="submit" value="Save this quizz."/>
    </div>
</template>

<script>

import {InputQuizz, InputQuizzItem} from '../classes/inputQuizz';
import { Axios } from 'axios'


export default {
    name: "EditQuizz",
    props: ['quizzContent', 'private'],
    data: function () {
        return {
            quizz: new InputQuizz("Sample quizz"),
            jsonExport: "",
            file: '',
            filename: 'Choose a background music...'
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
        },
        onFileChange(e) {
        //console.log(e.target.files[0]);
            this.filename = "Selected File: " + e.target.files[0].name;
            this.file = e.target.files[0];
        },
        uploadFile(id, type){
            let allofthem = document.querySelectorAll('input[type="file"]');
            console.log(allofthem);
            let theone = allofthem[2*id+1+type].files[0];
            console.log("theone : ");
            console.log(theone);

            /*let axios = new Axios();*/
            /*axios.post('/upload', post)*/
                    /*.then(res => {*/
                        /*commit('image', file.files[0])*/
                    /*}).catch(err => {*/
                        /*console.log(err)*/
            /*})*/
            let formData = new FormData();
            let that = this;
            if (type === 0){
                formData.append("image",theone);
                formData.append("typeUpload", 0);
            }
            else{
                formData.append("audio",theone);
                formData.append("typeUpload", 1);
            }
            axios.post('../upload',formData,{
                                headers: {
                      'Content-Type': 'multipart/form-data'
                    }}).then(function(e){
                        console.log("success apparently");
                        console.log(e);
                        let res = e.data; 
                        let s = "/storage/" + String(res.id) + "/" + String(res.filename);
                        console.log("voici la s");
                        console.log(s);
                        if (type === 0)
                            that.quizz.items[id].setImage(s);
                        else
                            that.quizz.items[id].setSound(s);
                    }).catch(function(err){
                        console.log("error");
                        console.log(err)
                        });

        }
    }
}


</script>
