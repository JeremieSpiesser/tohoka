module.exports.OutputQuizz = function(title) {
    return {
        title: title,
        items: [],
    }
}

module.exports.OutputQuizzItem = function(question, answers, type="qcm") {
    //question : the question (string)
    // questions : a list of {answer: str, correct: bool, userChoice: bool}  with all the questions (bool true if correct, false if not)
    return {
        question: question,
        answers: answers,
        total: 0,
        score: 0,
        type: type,
        isTrue: true,
        userUniqueChoice: undefined,
        userTfChoice: true,
        getAnswersTitles: function(){
            return this.answers.map((answer) => answer.question);
        },
        disableOthers: function(ans){
            console.log(ans);
            let i = this.answers.indexOf(ans);
            console.log(i);
            if (i!==-1){
                for (let j=0 ; j < this.answers.length ; j += 1){
                    if (j!==i){
                        this.answers[j].userChoice = false;
                    }
                }
            }
        },
        getNbGoodAnswers: function(){
            let n = 0;
            for(let ans of this.answers){
                if(ans.bool === true)
                    n++;
            }
            this.total = n;
            return this.total;
        },
        computeScore: function (){
            this.score = 0;
            for(let ans of this.answers){
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
    }
}

