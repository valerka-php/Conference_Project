<template>
    <Head title="Conference Category Page"/>
    <HomeLayout/>

    <div v-if="this.paginatedConferences.data.length < 1" class="category-is-empty">
        no conferences in this category
    </div>

    <Conferences
        v-else
        :unavailable-conference="unavailableConference"
        :user="$page.props.auth.user"
        :paginatedConferences="paginatedConferences"
        :share-url="shareUrl"
        :share-text="shareText"
        :user-reports="userReports"
    ></Conferences>
</template>

<script>
import {Head} from '@inertiajs/inertia-vue3';
import Conferences from "@/Pages/Home/Conferences.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";

export default {
    name: "Categories",

    components: {
        Head,
        Conferences,
        HomeLayout,
    },

    props: {
        paginatedConferences: Object,
        shareUrl: String,
        shareText: String,
        userReports: Array,
        unavailableConference: Array,
    },
}
</script>

<style scoped>

</style>
