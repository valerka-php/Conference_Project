<template>
    <div class="report-index">
        <div class="report-title">
            {{ report.title }}
        </div>
        <div class="report-time">
            {{ report.start_time.substring(0, 5) + ' - ' + report.end_time.substring(0, 5) }}
        </div>

        <div class="report-description">
            {{ report.description }}
        </div>

        <div class="report-footer-buttons">
            <Link
                class="btn btn-outline-secondary btn-report mr-5"
                :href="route('reports.show',{conference: report.conference_id})"
            >back
            </Link>

            <Link
                class="btn btn-outline-info download-btn bi bi-download mr-5"
                :href="'/download/' + report.presentation.split('/')[1]"
            >download
            </Link>

            <div v-if="isCreator">
                <Link
                    class="btn btn-outline-warning btn-report mr-5"
                    :href="route('reports.edit',{ report : report.id })"
                >Edit
                </Link>

                <Link
                    @click="deleteReport(report.id)"
                    class="btn btn-outline-danger btn-report mr-5"
                >Cancel
                </Link>
            </div>

            <div v-if="$page.props.auth.isAdmin">
                <Link
                    @click="deleteReport(report.id)"
                    class="btn btn-outline-danger btn-report mr-5"
                >delete
                </Link>

                <v-btn @click.prevent="exportComments">
                    export comments
                </v-btn>
            </div>
        </div>
    </div>

    <div class="text-center">
        <v-dialog
            v-model="dialog"
        >
            <v-card v-if="!file">
                <v-card-text class="dialog-spinner">
                    <v-progress-circular
                        color="primary"
                        indeterminate
                        :size="104"
                        :width="12"
                    ></v-progress-circular>
                    creating export
                </v-card-text>
                <v-card-actions>
                    <v-btn color="primary" block @click="resetDialog">Close Dialog</v-btn>
                </v-card-actions>
            </v-card>

            <v-card v-else class="export-dialog-link">
                <a
                    class="export-link"
                    target="_blank"
                    :href="route('downloads.file',{ file:file})"
                    @click="resetDialog"
                >click to download {{ file }}
                </a>
            </v-card>
        </v-dialog>
    </div>

    <hr class="mt-9">
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import BackButton from "@/Components/Buttons/BackButton.vue";
import axios from "axios";

export default {
    name: "Report",

    components: {
        BackButton,
        Link
    },

    data() {
        return {
            dialog: false,
            file: null,
        }
    },

    props: {
        report: Object,
        isCreator: Boolean,
        conferenceId: Number,
    },

    methods: {
        deleteReport(id) {
            if (confirm('Do you want delete it?')) {
                this.$inertia.delete(`/reports/${id}`)
            }
        },

        exportComments() {
            this.dialog = true

            axios.get(`/comments/${this.report.id}/export/csv`)
        },

        resetDialog() {
            this.dialog = false
            this.file = null
        }
    },

    mounted() {
        Echo.private(`export-comments`)
            .listen('CommentExportDone', (e) => {
                this.file = e.fileName
            });
    }
}
</script>

<style scoped>

</style>
