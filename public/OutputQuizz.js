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
    constructor(question,answers,type="qcm") {
        this.question = question;
        this.answers = answers;
        this.total = 0;
        this.score = 0;
        this.type = type;
        this.isTrue = true;
        this.userUniqueChoice = undefined;
        this.userTfChoice = true;
    }
    getQuestion(){
        return this.question;
    }
    getAnswersTitles(){
        return this.answers.map((answer) => answer.question);
    }
    getAnswers(){
        return this.answers;
    }
    //Finds an answer and switches all the others to false
    disableOthers(ans){
        console.log(ans);
        let i = this.answers.indexOf(ans);
        console.log(i);
        if (i!=-1){
            for (let j=0 ; j < this.answers.length ; j += 1){
                if (j!=i){
                    this.answers[j].userChoice = false;
                }            
            }
        }
    }
    getNbGoodAnswers() {
        var n = 0;
        for(var ans of this.getAnswers()){
            if(ans.bool === true)
                n++;
        }
        this.total = n;
        return this.total;
    }
    computeScore(){
        for(var ans of this.getAnswers()){
            if(ans.userChoice === undefined)
                ans.userChoice = false;
            if(ans.userChoice && (ans.userChoice === ans.bool))
                this.score++;
            else if ((ans.userChoice && !(ans.userChoice === ans.bool))|| (!ans.userChoice && ans.bool))
                this.score--;
        }
        if (this.score < 0)
            this.score = 0;
    }
    getScore() {
        return this.score;
    }
}


var playQuizz = new Vue({
    el: '#playQuizz',
    data: {
        quizz: new OutputQuizz(""),
        gameFinished: false,
        gameStarted: false,
        nbgoodanswers:0,
        nbpoints: 0,
        score: 0
    },
    methods: {
        reset() {
            //this.gamefinished = false;
            //this.gameStarted = true;
            this.nbgoodanswers = 0;
            this.nbpoints = 0;
            this.score = 0;
        },
        loadQuizz(text){
            this.gameStarted = true;
            this.reset();
            text = document.getElementById("userBackup").value;
            console.log("Corresponding json :");
            console.log(text);
            let instance = new OutputQuizz();                  // NOTE: if your constructor checks for unpassed arguments, then just pass dummy ones to prevent throwing an error
            let serializedObject = JSON.parse(text);
            Object.assign(instance, serializedObject);
            instance.items = instance.items.map((item) => new OutputQuizzItem(item.question, item.answers,item.type));
            this.quizz = instance;
            instance.items.forEach(function(item){
                item.userChoice = false;
            });
        },
        /*handleProgressBar(){
            var progress = document.getElementById("achievement");
            progress.focus();
            progress.style.width = this.score + "%";
            //progress.aria-valuenow = this.score;

        },*/
        toggleFinished() {
            this.reset();
            document.querySelectorAll('input[type=checkbox]').forEach((checkbox) => {
                checkbox.disabled = !checkbox.disabled;
            })
            this.gameFinished = !this.gameFinished;
            for (var item of this.quizz.items) {
                item.computeScore();
                this.nbpoints += item.getScore();
                this.nbgoodanswers += item.getNbGoodAnswers();
            }
            this.score = (this.nbpoints/this.nbgoodanswers) * 100;
            //this.handleProgressBar();
        }
    }
})
