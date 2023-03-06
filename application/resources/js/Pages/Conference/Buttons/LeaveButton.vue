<template>
    <button
        class="btn btn-outline-primary btn-leave"
        @click="submit"
    >
        Cancel
    </button>
</template>

<script>
export default {
    name: "LeaveButton",

    props: {
        conferenceId: Number,
        user: Object,
        titleConference: String,
    },

    data() {
        return {
            joined: false,
        }
    },

    methods: {
        submit() {
            if (this.user) {
                this.leave()
                this.$inertia.put(
                    `/conferences/${this.conferenceId}/leave`);
            } else {
                this.$inertia.get('login')
            }
        },

        leave() {
            this.$store.commit('leaveConference', this.conferenceId)
        }
    }
}
</script>

<style scoped>

</style>
