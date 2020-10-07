class InputQuizz{
    constructor(title) {
        this.title = title;
        this.items = [];
    }
    addItem(){
        console.log("Ajout d'un item");
        this.items.push(new InputQuizzItem("Sample question", ["answer1", "answer2"],[1]));
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
    // questions : a list of strings with all the questions
    //correctAnswers : a list of indexes (starting from 0 to n-1) with the correct answers in questions
    constructor(question,possibleAnswers,correctAnswers){
        if (correctAnswers.map((index) => ((0 <= index) && (index < possibleAnswers.length))).reduce((a,b) => a && b)) {
            this.question = question;
            this.possibleAnswers = possibleAnswers;
            this.correctAnswers = correctAnswers;
        }else{
            return null;
        }
    }
    getQuestion(){
        return this.question;
    }
    //Returns a list of indexes and text of the correct answers
    printCorrectAnswers(){
        return this.correctAnswers.map((i)=>(i,this.possibleAnswers[i]))
    }
    getCorrectAnswers(){
        return this.correctAnswers
    }
    getPossibleAnswers(){
        return this.possibleAnswers
    }
    addCorrectAnswer(i){
        if ((0 <= i) && (i< this.possibleAnswers.length))
            this.correctAnswers.push(i)
    }
    delCorrectAnswer(i){
        if ((0 <= i) && (i< this.possibleAnswers.length)) {
            let u = this.correctAnswers.indexOf(i);
            if (u > -1) {
                this.correctAnswers.splice(u, 1);
            }
        }
    }
    addPossibleAnswer(answer="another one"){
        this.possibleAnswers.push(answer)
    }

}


var app = new Vue({
    el: '#app',
    data: {
        quizz: new InputQuizz("sample quizz")
    },
    methods: {

    }
})
