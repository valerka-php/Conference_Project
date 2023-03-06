<template>
    <Head title="Reports"/>
    <ConferenceLayout/>

    <ReportFilter :conference-id="conference.id" :categories="categories" > </ReportFilter>

    <div v-if="reports.data.length < 1" class="favorite-reports">
        <div>
            no reports
        </div>
    </div>

    <div v-else class="report-cards">
        <div v-for="report in reports.data" class="card-report">
            <Card
                :accepted-conference="acceptedConference"
                :report="report"
                :conference-id="conference.id"
                :start-date="conference.date"
            />
        </div>
    </div>

    <Pagination
        :links="reports.links"
    ></Pagination>
</template>

<script>
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import {Head} from '@inertiajs/inertia-vue3';
import Card from "@/Pages/Report/Card.vue";
import ReportFilter from "@/Pages/Report/Filter/ReportFilter.vue";
import Pagination from "@/Pages/Home/Pagination.vue";

export default {
    name: "ShowReports",

    components: {
        Pagination,
        ReportFilter,
        Card,
        ConferenceLayout,
        Head
    },

    props: {
        acceptedConference: Boolean,
        reports: Object,
        categories: Object,
        conference: Object,
    },
}
</script>

<style scoped>

</style>
