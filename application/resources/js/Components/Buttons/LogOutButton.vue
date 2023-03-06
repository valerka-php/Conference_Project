<template>
    <v-form>
        <v-btn
            @click="submit"
            class="btn btn-outline-secondary btn-logout"
        >
            Log out
        </v-btn>
    </v-form>
</template>

<script>
export default {
    name: "LogOutButton",

    methods: {
        submit() {
            this.$inertia.post('/logout')
        }
    }
}
</script>

<style scoped>

</style>
