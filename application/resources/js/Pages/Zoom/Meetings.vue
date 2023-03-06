<template>
    <Head title="Zoom Meetings Page"/>

    <HomeLayout :can-register="canRegister"/>

    <v-table class="zoom-links-table">
        <thead>
        <tr>
            <th class="text-left">
                report title
            </th>
            <th class="text-left">
                zoom uuid
            </th>
            <th class="text-left">
                zoom id
            </th>
            <th class="text-left">
                zoom host_id
            </th>
            <th class="text-left">
                zoom topic
            </th>
            <th class="text-left">
                zoom type
            </th>
            <th class="text-left">
                zoom start_time
            </th>
            <th class="text-left">
                zoom timezone
            </th>
            <th class="text-left">
                zoom created_at
            </th>
            <th class="text-left">
                zoom join_url
            </th>
        </tr>
        </thead>
        <tbody>
        <tr
            v-for="report in zoomReports.data"
        >
            <td>{{ report.title }}</td>
            <td>{{ report.zoom_uuid }}</td>
            <td>{{ report.zoom_id }}</td>
            <td>{{ report.zoom_host_id }}</td>
            <td>{{ report.zoom_topic }}</td>
            <td>{{ report.zoom_type }}</td>
            <td>{{ report.zoom_start_time }}</td>
            <td>{{ report.zoom_timezone }}</td>
            <td>{{ report.zoom_created_at }}</td>
            <td style="width: 55px">
                <Link :href="report.join_url"> {{ report.join_url }}</Link>
            </td>
        </tr>
        </tbody>
    </v-table>

    <Pagination
        :links="zoomReports.links"
    ></Pagination>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3';
import HomeLayout from "@/Layouts/HomeLayout.vue";
import Pagination from "@/Pages/Home/Pagination.vue";

export default {
    name: "Meetings",

    components: {
        Head,
        Link,
        HomeLayout,
        Pagination
    },

    props: {
        zoomReports: Object,
    },
}
</script>

<style scoped>

</style>
