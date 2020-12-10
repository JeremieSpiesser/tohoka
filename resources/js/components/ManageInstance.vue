<template>
    <div>
        <div class="container-fluid">
            <div class="row">
                <div class="col">
                    <h1>{{ idInstance }}</h1>
                    <button @click="openNextQuestion()" type="button">Open the next question</button>
                    <div id="send-feedback">{{ sendFeedback }}</div>
                </div>
                <div class="col">
                    <users-list :channelSocket="channelSocket" :masterId="masterId"></users-list>
                </div>
            </div>

        </div>
    </div>
</template>

<script>

import UsersList from "./UsersList";
export default {
    name: "ManageInstance",
    props: ['idInstance', 'masterId'],
    components: {
        UsersList
    },
    data: function(){
        return {
            sendFeedback: "",
            channelSocket: undefined
        }
    },
    beforeMount(){
        this.channelSocket = window.Echo.join('playquizz.' + this.idInstance);
    },
    mounted() {
    },
    methods: {
        openNextQuestion(){
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
