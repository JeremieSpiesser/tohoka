<template>
    <div>
        <div class="container-fluid">
            <div v-if="gameStarted" class="row pt-3 pb-4">
                <timer :on-complete="() => {this.btnDisableFlag = false; this.timeout = true;}" :timeout="timeout"></timer>
            </div>
            <div class="row">
                <div class="col">
                    <h1 v-if="currentQuestion >= 0">Question : {{currentQuestion }}</h1>
                    <h2>Code : {{ idInstance }}</h2>
                    <button @click="openNextQuestion()" :disabled="btnDisableFlag" type="button">{{ parseInt(currentQuestion) + 1 === parseInt(quizzNum) ? 'Voir les résultats' : gameStarted ? 'Question suivante' : 'Démarrer le jeu' }}</button>
                    <div id="send-feedback">{{ sendFeedback }}</div>
                </div>
                <div class="col">
                    <users-list :channelSocket="channelSocket" :masterId="masterId"></users-list>
                </div>
            </div>
            <div class="row">
                <h3 class="d-flex justify-content-center font-weight-bold fixed-bottom">
                    Lien de partage : <a target="_blank" :href="`/play/${ idInstance }`"> {{ baseUrl }}/play/{{ idInstance }}</a>
                </h3>
            </div>
        </div>
    </div>
</template>

<script>

import UsersList from "./UsersList";

export default {
    name: "ManageInstance",
    props: ['idInstance', 'masterId', 'quizzNum'],
    components: {
        UsersList
    },
    data: function(){
        return {
            currentQuestion: -1,
            sendFeedback: "",
            gameStarted: false,
            btnDisableFlag: false,
            timeout: false,
            channelSocket: undefined,
            baseUrl: `${window.location.protocol}//${window.location.host}`
        }
    },
    beforeMount(){
        this.channelSocket = window.Echo.join('playquizz.' + this.idInstance);
        this.channelSocket.listen('NextQuestion', e => {
            this.gameStarted = true;
            this.timeout = false;
            this.currentQuestion = e.idQuestion;
        });
    },
    mounted() {
    },
    methods: {
        openNextQuestion(){
            this.btnDisableFlag = true;

            const formData = new FormData();
            formData.append('idInstance', this.idInstance);

            let that = this;

            const res = /*await*/ axios.post('openNextQuestion', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(function (response) {

            })
            .catch(function (error){
                if (error.response){
                    // Out of 2xx
                    var errMessage = "Error " + error.response.status + " : " + error.response.data.message;
                    that.sendFeedback = errMessage;
                    console.log(errMessage);
                }
                else if (error.request){
                    // No response
                    console.log("Error sending the request");
                }
                else {
                    console.log('Unknown error');
                    // Unknow error
                }
            });
        }
    }
}
</script>
