<template>
    <div class="mt-5">
        <div class="row">
            <input class="form-control mr-2" v-model="enteredCode" placeholder="Entrez le code ...">
        </div>
        <div class="d-flex justify-content-center align-items-center row mt-5">
            <a :href="`/play/${enteredCode}`" class="btn btn-lg btn-primary align-middle">Rejoindre</a>
        </div>
    </div>
</template>

<script>
export default {
    name: "JoinInstance",
    data: () => {
        return {
            enteredCode: ''
        }
    }
}
</script>
