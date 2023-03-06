<template>
    <Head title="Search Result"/>
    <HomeLayout :can-register="canRegister"/>

    <div class="search-result">
        <div class="accordion accordion-flush mt-10" style="width: 230px;" id="accordionFlushExample">
            <div class="accordion-item" v-if="conferences.length >= 1">
                <h2 class="accordion-header" id="flush-headingOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                        Conference
                    </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne"
                     data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul v-for="conference in conferences">
                            <a target="_blank" :href="route('conferences.show',{conference:conference.id})">
                                {{ conference.title }} </a>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="accordion-item" v-if="reports.length >= 1">
                <h2 class="accordion-header" id="flush-headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                        Report
                    </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo"
                     data-bs-parent="#accordionFlushExample">
                    <div class="accordion-body">
                        <ul v-for="report in reports">
                            <a target="_blank" :href="route('report.home',{report:report.id})"> {{ report.title }} </a>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-if="reports.length < 1 && conferences.length < 1" class="conference-empty">
        Nothing was found
    </div>
</template>
<script>
import {Head} from '@inertiajs/inertia-vue3';
import HomeLayout from "@/Layouts/HomeLayout.vue";

export default {
    name: "ShowResult",
    components: {
        HomeLayout,
        Head
    },

    props: {
        conferences: Object,
        reports: Object,
    },
}
</script>

<style scoped>

</style>
