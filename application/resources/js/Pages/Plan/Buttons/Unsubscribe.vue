<template>
    <v-btn
        :href="route('subscription.cancel',{ plan:planName })"
        class="btn btn-primary btn-block shadow rounded-pill"
    >Unsubscribe
    </v-btn>
</template>

<script>
export default {
    name: "Unsubscribe",

    props: {
        planName: String,
    },
}
</script>

<style scoped>

</style>
