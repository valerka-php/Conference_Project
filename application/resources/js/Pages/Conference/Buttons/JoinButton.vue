<template>
    <button
        class="btn btn-outline-primary btn-join"
        @click="submit"
    >
        Join
    </button>
</template>

<script>
export default {
    name: "JoinButton",

    props: {
        conferenceId: Number,
        conferenceTitle: String,
        user: Object,
        isListener: false,
        remainingConferences: String,
    },

    data() {
        return {
            joined: false,
        }
    },

    methods: {
        submit() {
            if (this.user && this.allowJoin()) {
                this.join()
                this.$inertia.put(`/conferences/${this.conferenceId}/join`);
            } else if (!this.allowJoin()) {
                this.$inertia.get(route('plans.show', {message: 'You have reached limit join to the conferences'}));
            } else {
                this.$inertia.get('login')
            }
        },

        join() {
            this.$store.commit('joinConference', this.conferenceId)
        },

        allowJoin() {
            return this.remainingConferences > this.$store.getters.getAcceptedConferences.length
        }
    },
}
</script>

<style scoped>

</style>
