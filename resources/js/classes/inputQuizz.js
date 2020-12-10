module.exports.InputQuizz = function(title){
    return {
        title: title,
        items: [],
        addItem: function(){
            this.items.push(new module.exports.InputQuizzItem("Sample question", [
                {
                    answer: "Number one",
                    bool: true
                },
                {
                    answer: "Number two",
                    bool: false
                }]));
        },
        removeItemAt: function(i){
            if (i > -1) {
                this.items.splice(i, 1);
            }
        },
        toJson: function(){
            let obj = {};
            obj.title = this.title;
            obj.items = this.items;
            return JSON.stringify(obj);
        }
    }
}

//question : the question (string)
// questions : a list of {answer: str, correct: bool }  with all the questions (bool true if correct, false if not)
// type :  "qcm" if the question is a "QCM" but the user doesn't know it,
//         "tf" if the question is a true or false
//         "classic" if the question is a classic question with only one answer
//         "qcma" if the question is a "QCM" but the user knows that multiple answers are possible
module.exports.InputQuizzItem = function(question, answers, type="qcm"){
    return {
        question: question,
        answers: answers,
        type: type,
        //variable used only if the item gets transformed to a true/false question
        isTrue: true,
        imageUrl: undefined,
        getAnswersTitles: function(){
            return this.answers.map((answer) => answer.question)
        },
        addPossibleAnswer: function(answer="Another one", bool=true){
            this.answers.push({
                answer: answer,
                bool : false
            });
        },
        setImage: function(url){
            this.imageUrl = url;
        },
        switchToTf: function(){
            if (this.type !== "tf"){
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
        },removeItemAt: function(i){
            if (i > -1) {
                this.answers.splice(i, 1);
            }
        },
        disableOthers: function(ans){
            let i = this.answers.indexOf(ans);
            if (i!==-1){
                for (let j=0 ; j < this.answers.length ; j += 1){
                    this.answers[j].bool = i === j;
                }
            }
        }
    }
}
