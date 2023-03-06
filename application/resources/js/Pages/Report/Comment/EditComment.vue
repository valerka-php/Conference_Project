<template>
    <Head title="Create comment"/>
    <ConferenceLayout/>

    <Report
        :is-creator="isCreator"
        :report="report"
    ></Report>

    <div class="comment-editor">
        <ckeditor :editor="editor" v-model="form.text" :config="editorConfig"></ckeditor>
        <div class="error-form" v-if="errors.text"> {{ errors.text }}</div>
        <div class="comment-editor-footer">
            <v-btn @click="submit">send</v-btn>
        </div>
    </div>


</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3';
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import Report from "@/Pages/Report/Report.vue";
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

export default {
    name: "CreateComment",

    components: {
        Report,
        ConferenceLayout,
        Head,
        Link,
        ClassicEditor
    },

    props: {
        report: Array,
        isCreator: Boolean,
        firstName: String,
        lastName: String,
        creatorId: Number,
        errors: Object,
        text: String,
        commentId: Number,
    },

    data() {
        return {
            editor: ClassicEditor,
            form: {
                report_id: '',
                text: '',
                first_name: '',
                last_name: '',
            },

            editorConfig: {
                // The configuration of the editor.
            }
        };
    },

    methods: {
        submit() {
            if (confirm('Do you want save it?')) {
                this.$inertia.post(`/comments/${this.commentId}/update`, this.form)
            }
        },
    },

    mounted() {
        this.form.text = this.text
        this.form.report_id = this.report.id
        this.form.first_name = this.firstName
        this.form.last_name = this.lastName
    }
}
</script>

<style scoped>

</style>
