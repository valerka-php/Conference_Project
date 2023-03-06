<template>
    <Head title="Create comment"/>
    <ConferenceLayout/>

    <Report
        :is-creator="isCreator"
        :report="report"
    ></Report>

    <div class="mt-4 report-add-comment">
        <back-button class="btn-conference mr-5"></back-button>
    </div>

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
import BackButton from "@/Components/Buttons/BackButton.vue";

export default {
    name: "CreateComment",

    components: {
        BackButton,
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
    },

    data() {
        return {
            titleRules: [
                value => !!value || 'Name is required',
                value => (value && value.length <= 255) || 'Name must be less than 255 characters',
                value => (value && value.length >= 2) || 'Name must be more than 2 characters',
            ],
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
            this.$inertia.post(`/comments`, this.form)
        },
    },

    mounted() {
        this.form.report_id = this.report.id
        this.form.first_name = this.firstName
        this.form.last_name = this.lastName
    }
}
</script>

<style scoped>

</style>
