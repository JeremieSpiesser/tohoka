<template>
    <div>
        <div class="col" v-for="(user, index) in connectedUsers">
            <p>{{ user.name }} --> {{ user.state }}</p>
        </div>
    </div>
</template>

<script>
export default {
    name: "UsersList",
    props: ['channelSocket', 'masterId'],
    data: function(){
        return {
            connectedUsers: {},
            myUserId: ''
        }
    },
    mounted() {
        console.log(this.masterId);
        this.channelSocket
            .here(users => {
                console.log('Here: ' + JSON.stringify(users));
                users.forEach(user => {
                    if(this.myUserId === undefined){
                        this.myUserId = user.id;
                    }

                    if(user.id == this.masterId){
                        user.state = "Animateur";
                    }
                    Vue.set(this.connectedUsers, user.id, user);
                });
            })
            .joining(user => {
                console.log('Joining: ' + JSON.stringify(user));
                Vue.set(this.connectedUsers, user.id, user);
            })
            .leaving(user => {
                console.log('Leaving: ' + JSON.stringify(user));
                Vue.delete(this.connectedUsers, user.id);
            })
            .listen('UserStateChanged', e => {
                Vue.set(this.connectedUsers[e.id], 'state', e.state);
            })
    }
}
</script>

<style scoped>

</style>
