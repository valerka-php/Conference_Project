<template>
    <Head title="Report"/>
    <ConferenceLayout/>

    <v-breadcrumbs
        :items="breacrumbItems"
        divider="/"
    ></v-breadcrumbs>

    <Report
        :report="report"
        :is-creator="isCreator"
    ></Report>

    <div class="mt-4 report-add-comment">
        <Link
            :href="route('comments.create',{report: report.id})"
            class="btn btn-outline-secondary comment-add-btn mr-5"
        >add comment
        </Link>
    </div>

    <div v-for="comment in comments">
        <comment
            :creator-id="comment.creator_id"
            :report-id="report.id"
            :comment-id="comment.id"
            :first-name="comment.first_name"
            :last-name="comment.last_name"
            :text="comment.text"
            :created-at="comment.created_at"
            :updated-at="comment.updated_at"
        ></comment>
    </div>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3';
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import Comment from "@/Pages/Report/Comment/Comment.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
import Report from "@/Pages/Report/Report.vue";
import _ from 'lodash';
import axios from "axios";

export default {
    name: "ShowReport",

    props: {
        report: Object,
        isCreator: Boolean,
        breadcrumbs: Array,
    },

    data() {
        return {
            breacrumbItems: [],
            comments: [],
        }
    },

    components: {
        Report,
        Comment,
        BackButton,
        ConferenceLayout,
        Head,
        Link
    },

    methods: {
        setBreadcrumbItems(array) {
            this.breacrumbItems.unshift({
                title: array.title,
                href: `/reports/category/${array.id}`,
            });

            if (array.parents) {
                this.setBreadcrumbItems(array.parents)
            }
        },

        fetch(offset = 0) {
            axios.get(`/comments/${this.report.id}`, {
                params: {
                    offset: offset
                }
            })
                .then(response => {
                    this.comments = this.comments.concat(response.data)
                })
        }
    },

    created() {
        const eventHandler = () => {

            const positionScrollTop = document.documentElement.scrollTop
            const viewportHeight = window.innerHeight
            const totalHeight = document.documentElement.offsetHeight

            const atTheBottom = positionScrollTop + viewportHeight > totalHeight - 100;

            if (atTheBottom) {
                this.fetch(this.comments.length)
            }
        };

        let delayedHandler = _.debounce(eventHandler, 300)
        document.addEventListener('scroll', delayedHandler)
    },

    mounted() {
        this.fetch();

        if (this.breadcrumbs['parents']) {
            this.setBreadcrumbItems(this.breadcrumbs['parents'])
        }

        this.breacrumbItems.push({
            title: this.breadcrumbs.child.title,
            href: `/reports/category/${this.breadcrumbs.child.id}`,
        })
    }
}
</script>

<style scoped>

</style>
