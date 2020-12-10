<template>
    <div>
        <h1>Quizz : {{ quizz.title }}</h1>
        <input type="textbox" name="name" v-model="quizz.title" />

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
            <li v-for="(item,ind) in quizz.items">
                <h3>{{ item.question }} </h3>
                <p>Insert a picture if relevant </p>
                <input type="file" on:change="handleFileUpload()" ref="file"><input type="button" value="Upload" @click="uploadImage(ind)">
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

                        <li>  {{ index }} : {{ possAnswer.answer }} </li>  <input type="textbox" v-model="possAnswer.answer" />
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
                        <li>  {{ index }} : {{ possAnswer.answer }} </li>  <input type="textbox" v-model="possAnswer.answer" />
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
        <input v-on:click="populateJson()" name="submit" type="submit" value="Save this quizz."/>
    </div>
</template>

<script>

import {InputQuizz, InputQuizzItem} from '../classes/inputQuizz';
import { Axios } from 'axios'


export default {
    name: "EditQuizz",
    props: ['quizzContent'],
    data: function () {
        return {
            quizz: new InputQuizz("Sample quizz"),
            jsonExport: "",
            file: ''
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
        uploadImage(id){
            let allofthem = document.querySelectorAll('input[type="file"]');
            console.log(allofthem);
            let theone = allofthem[id+1].files[0];
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
            formData.append("image",theone);
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
                        that.quizz.items[id].setImage(s);
                    }).catch(function(err){
                        console.log("error");
                        console.log(err)
                        });

        }
    }
}
</script>
