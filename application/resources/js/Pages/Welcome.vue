<script>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Conferences from "@/Pages/Home/Conferences.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import Burger from "@/Components/Burger.vue";
import ConferenceFilter from "@/Pages/Conference/Filter/ConferenceFilter.vue";

export default {
    components: {
        ConferenceFilter,
        Burger,
        Head,
        Link,
        Conferences,
        HomeLayout
    },

    props: {
        allConferences: Object,
        acceptedConferences: Array,
        paginatedConferences: Object,
        canLogin: Boolean,
        canRegister: Boolean,
        laravelVersion: String,
        phpVersion: String,
        shareUrl: String,
        shareText: String,
        userReports: Array,
        unavailableConference: Array,
        favoriteReports: Array,
        categories: Object,
        maxReport: Number,
        maxDate: String,
        minDate: String,
        paymentSuccess: String,
        remainingConferences: String,
    },

    mounted() {
        this.$store.commit("setConferences", this.allConferences);
        this.$store.commit("setAcceptedConferences", this.acceptedConferences);

        if (this.paymentSuccess) {
            this.$page.props.flash.message = 'Your subscription has been updated'
        }
    }
}

</script>

<template>
    <Head title="Home Page"/>

    <HomeLayout :can-register="canRegister"/>

    <ConferenceFilter
        v-if="$page.props.auth.user"
        :max-date="maxDate"
        :min-date="minDate"
        :maxReport="maxReport"
        :categories="categories"
    />

    <Conferences
        :accepted-conferences="acceptedConferences"
        :remaining-conferences="remainingConferences"
        :unavailable-conference="unavailableConference"
        :user="$page.props.auth.user"
        :paginatedConferences="paginatedConferences"
        :share-url="shareUrl"
        :share-text="shareText"
        :user-reports="userReports"
    ></Conferences>
</template>

