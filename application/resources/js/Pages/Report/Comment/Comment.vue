<template>
    <div class="comment">
        <div class="comment-title">
            <div>{{ firstName }} {{ lastName }}</div>
            <div>{{ parseDate(this.createdAt) }}</div>
        </div>
        <div class="comment-text"><span v-html="text"></span></div>
        <div class="comment-edit-btn" v-if="!expiredTime() && isCreator()">
            <v-btn :href="route('comments.edit',{ comment: commentId, report: reportId})">
                edit
            </v-btn>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comment",

    props: {
        creatorId: Number,
        firstName: String,
        lastName: String,
        text: String,
        createdAt: String,
        updatedAt: String,
        commentId: Number,
        reportId: Number,
    },

    methods: {
        parseDate(date) {
            const createdAt = new Date(date);
            return createdAt.toString().substring(4, 24)
        },

        isCreator() {
            return this.creatorId === this.$page.props.auth.user.id
        },

        expiredTime() {
            const now = Date.now()
            const updatedAt = new Date(this.parseDate(this.updatedAt))
            const tenMinutes = 600000;

            if ((now - updatedAt) > tenMinutes) {
                return true;
            }
            return false;
        }
    },
}
</script>

<style scoped>

</style>
