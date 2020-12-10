<template>
    <div class="container" id="progressbar">
        <div class="align-middle">
            Temps restant : {{left/10}}s
        </div>
        <div class="progress">
            <div class="progress-bar progress-bar-striped" v-bind:class="{ 'bg-success': left > percentToSec(50), 'bg-warning': left > percentToSec(20) && left <= percentToSec(50), 'bg-danger': left <= percentToSec(20) }" role="progressbar" aria-valuemin="0" aria-valuemax="100" :style="{'width': `${Math.round(left * 100.0 / maxSec)}%`}">
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Timer",
    props: ['onComplete', 'timeout'],
    watch: {
        timeout: function(newVal, oldVal) { // watch it
            if(newVal){
                this.left = 0;
            }else{
                this.left = this.maxSec;
                setTimeout(this.countdown, 100);
            }
        }
    },
    data: () => {
        return {
            left: 140,
            maxSec: 140
        }
    },
    mounted() {
        setTimeout(this.countdown, 100);
    },
    methods: {
        percentToSec(perc){
            return Math.round(perc * this.maxSec / 100.0);
        },
        countdown(){
            this.left--;
            if(this.left <= 0){
                if(this.onComplete !== undefined){
                    this.onComplete();
                }
            }else{
                setTimeout(this.countdown, 100);
            }
        }
    }
}
</script>

<style scoped>

</style>
