class InputQuizz{
    constructor(title) {
        this.title = title;
        this.items = [];
    }
    addItem(){
        console.log("Items : ");
        console.log(this.items);
        this.items.push(new InputQuizzItem("Sample question", [
            {
                answer: "Number one",
                bool: true
            },
            {
                answer: "Number two",
                bool: false
            }]));
    }
    removeItemAt(i){
        let u = this.items.indexOf(i);
        if (u > -1) {
            this.items.splice(u, 1);
        }
    }
    getTitle(){
        return this.title;
    }
    toJson(){
        return JSON.stringify(this);
    }

}

class InputQuizzItem{
    //question : the question (string)
    // questions : a list of {answer: str, correct: bool }  with all the questions (bool true if correct, false if not)
    // type :  "qcm" if the question is a "QCM" but the user doesn't know it, 
    //         "tf" if the question is a true or false
    //         "classic" if the question is a classic question with only one answer
    //         "qcma" if the question is a "QCM" but the user knows that multiple answers are possible
    constructor(question,answers,type="qcm") {
        this.question = question;
        this.answers = answers;
        this.type = type;
        //variable used only if the item gets transformed to a true/false question
        this.isTrue = true;
    }
    getQuestion(){
        return this.question;
    }
    getAnswersTitles(){
        return this.answers.map((answer) => answer.question)
    }
    addPossibleAnswer(answer="another one", bool=true){
        this.answers.push({
            answer: answer,
            bool : false
        });
    }
    getAnswers(){
        return this.answers
    }
    //not used
    switchToTf(){
        if (this.type != "tf"){
            this.type = "tf"
            this.answers = []
            this.isTrue = true
        }else{
            this.answers = [
            {
                answer: "Number one",
                bool: true
            },
            {
                answer: "Number two",
                bool: true
            }];
        }
    }
    //Finds an answer and switches all the others to false
    disableOthers(ans){
        let i = this.answers.indexOf(ans);
        if (i!=-1){
            for (let j=0 ; j < this.answers.length ; j += 1){
                this.answers[j].bool = false||(i==j);
            }
        }
    }
}

var app = new Vue({
    el: '#vue-app',
    data: {
        quizz: new InputQuizz("sample quizz"),
        jsonExport: ""
    },
    mounted: function(){
        if (typeof chaine !== 'undefined'){
        this.loadQuizz(chaine);
        }
    },
    methods: {
        populateJson(){
            this.jsonExport = this.quizz.toJson();
        },
        loadQuizz(text){
            let instance = new InputQuizz();                  // NOTE: if your constructor checks for unpassed arguments, then just pass dummy ones to prevent throwing an error
            let serializedObject = JSON.parse(text);
            Object.assign(instance, serializedObject);
            instance.items = instance.items.map((item) => new InputQuizzItem(item.question, item.answers));
            this.quizz = instance;
        }
    }

    })
