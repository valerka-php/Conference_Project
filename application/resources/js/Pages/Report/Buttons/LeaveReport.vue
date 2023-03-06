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
    name: "LeaveReport",

    props: {
        conferenceId: Number,
        reportId: Number,
    },

    methods: {
        submit() {
            if (confirm('Do you want leave the conference and delete the report?')) {
                this.leave()
                this.$inertia.put(`/reports/${this.reportId}/leave`);
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
