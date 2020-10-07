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
    constructor(question,answers) {
        this.question = question;
        this.answers = answers;
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
}


var app = new Vue({
    el: '#app',
    data: {
        quizz: new InputQuizz("sample quizz"),
        jsonExport: ""
    },
    methods: {
        populateJson(){
            this.jsonExport = this.quizz.toJson();
        }

    }
})
