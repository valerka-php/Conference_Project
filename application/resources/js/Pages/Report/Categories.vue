<template>
    <Head title="Report Category"/>
    <ConferenceLayout/>

    <div v-if="this.reports.length < 1" class="category-is-empty">
        no reports in this category
    </div>

    <div v-else class="report-cards">
        <div v-for="report in reports" class="card-report">
            <Card
                :report-id="report.id"
                :title="report.title"
                :description="report.description"
                :end-time="report.end_time"
                :start-time="report.start_time"
                :count-comments="report.comments"
            />
        </div>
    </div>
</template>

<script>
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import {Head} from '@inertiajs/inertia-vue3';
import Card from "@/Pages/Report/Card.vue";

export default {
    name: "Categories",

    components: {
        Card,
        ConferenceLayout,
        Head,
    },

    props: {
        reports: Object,
    },
}
</script>

<style scoped>

</style>
