class OutputQuizz{
    constructor(title) {
        this.title = title;
        this.items = [];
    }
    getTitle(){
        return this.title;
    }
}

// Same as InputQuizzItem for now, while using simple quizz output
class OutputQuizzItem{
    //question : the question (string)
    // questions : a list of {answer: str, correct: bool, userChoice: bool}  with all the questions (bool true if correct, false if not)
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
    getAnswers(){
        return this.answers
    }
}


var playQuizz = new Vue({
    el: '#playQuizz',
    data: {
        quizz: new OutputQuizz(""),
        gameFinished: false
    },
    methods: {
        loadQuizz(text){
            text = document.getElementById("userBackup").value;
            console.log("Corresponding json :");
            console.log(text);
            let instance = new OutputQuizz();                  // NOTE: if your constructor checks for unpassed arguments, then just pass dummy ones to prevent throwing an error
            let serializedObject = JSON.parse(text);
            Object.assign(instance, serializedObject);
            instance.items = instance.items.map((item) => new OutputQuizzItem(item.question, item.answers));
            this.quizz = instance;
        },
        toggleFinished(){
            document.querySelectorAll('input[type=checkbox]').forEach((checkbox)=>{
                checkbox.disabled = !checkbox.disabled;
            })
            this.gameFinished = !this.gameFinished;
        }
    }
})