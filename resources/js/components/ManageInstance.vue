<template>
    <div>
        <h1>{{ idInstance }}</h1>
        <button @click="openNextQuestion()" type="button">Open the next question</button>
        <div id="send-feedback">{{ sendFeedback }}</div>
    </div>
</template>

<script>

export default {
    name: "ManageInstance",
    props: ['idInstance'],
    components: {
    },
    data: function(){
        return {
            sendFeedback: ""
        }
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
                // Success
                this.loadNextQuestion();
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
