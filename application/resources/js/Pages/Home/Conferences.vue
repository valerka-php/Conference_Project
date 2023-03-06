<template>
    <div v-if="paginatedConferences.data <= 0" class="conference-empty">
        conferences not found
    </div>

    <div>
        <div class="conference-card-body">
            <v-card
                class="conference-card"
                v-for="conference in paginatedConferences.data"
            >
                <v-card-text>
                    <div>{{ conference.date.substring(0, 10) }}</div>
                    <p class="text-h4 text--primary title-conference">
                        {{ conference.title }}
                    </p>
                </v-card-text>
                <v-card-actions
                    class="card-footer"
                    v-if="!this.$page.props.guest.user"
                >
                    <div class="card-footer-buttons">
                        <div class="card-footer-top-layer">
                            <Link
                                v-if="conference.reports.length >= 1 "
                                :href="route('reports.show',{conference:conference.id})"
                                class="btn btn-outline-secondary btn-top-layer"
                            >
                                reports
                            </Link>
                        </div>
                        <div class="card-footer-bottom-layer">
                            <Link
                                :href="route('conferences.show',{ id: conference.id })"
                                class="btn btn-outline-primary btn-details mr-7"
                                @click="this.$store.commit('clearCoordinates')"
                                :user="user"
                            >
                                Details
                            </Link>

                            <div v-if="this.$page.props.auth.isAnnouncer">
                                <div v-if="listenerCanJoin(conference.id)">
                                    <leave-report
                                        v-if="this.$store.getters.getAcceptedConferences.includes(conference.id)"
                                        :report-id="getReportId(conference.id)"
                                        :conference-id="conference.id"
                                    />

                                    <Link
                                        v-else-if="this.notAllowJoin()"
                                        class="btn btn-outline-primary btn-join"
                                        :href="route('plans.show',{message: 'You have reached limit join to the conferences'})"
                                    > join
                                    </Link>

                                    <Link
                                        v-else
                                        class="btn btn-outline-primary btn-join"
                                        :href="route('reports.create',{conference: conference.id})"
                                    > join
                                    </Link>
                                </div>

                                <div v-else class="not-available-conference">
                                    <button
                                        class="btn btn-outline-primary btn-join "
                                        disabled
                                    >not available
                                    </button>
                                </div>
                            </div>

                            <div v-else>
                                <LeaveButton
                                    v-if="this.$store.getters.getAcceptedConferences.includes(conference.id)"
                                    :conferenceId="conference.id"
                                    :titleConference="conference.title"
                                    :user="user"
                                ></LeaveButton>

                                <JoinButton
                                    v-else
                                    :remaining-conferences="remainingConferences"
                                    :conferenceTitle="conference.title"
                                    :conferenceId="conference.id"
                                    :user="user"
                                ></JoinButton>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer-links mt-2">
                        <div v-if="this.$store.getters.getAcceptedConferences.includes(conference.id)">
                            <SocialMedia
                                :url="`${this.shareUrl + conference.id}`"
                                :text="`${this.shareText}`"
                            />
                        </div>
                    </div>
                </v-card-actions>
            </v-card>
        </div>
    </div>

    <Pagination
        :links="paginatedConferences.links"
    ></Pagination>
</template>

<script>
import Pagination from "@/Pages/Home/Pagination.vue";
import JoinButton from "@/Pages/Conference/Buttons/JoinButton.vue";
import LeaveButton from "@/Pages/Conference/Buttons/LeaveButton.vue";
import {Link} from '@inertiajs/inertia-vue3';
import SocialMedia from "@/Pages/Conference/Buttons/SocialMedia.vue";
import DeleteButton from "@/Pages/Conference/Buttons/DeleteButton.vue";
import LeaveReport from "@/Pages/Report/Buttons/LeaveReport.vue";

export default {
    data() {
        return {
            data: this.acceptedConferences,
        }
    },

    components: {
        LeaveReport,
        DeleteButton,
        Pagination,
        Link,
        JoinButton,
        LeaveButton,
        SocialMedia,
    },

    props: {
        user: Object,
        userReports: Array,
        paginatedConferences: Object,
        links: Array,
        shareUrl: String,
        shareText: String,
        unavailableConference: Array,
        remainingConferences: String,
        acceptedConferences: Number,
    },

    methods: {
        getReportId(conferenceId) {
            for (let key in this.userReports) {
                if (conferenceId === this.userReports[key].conference_id) {
                    return this.userReports[key].id
                }
            }
        },

        listenerCanJoin(conference) {
            if (this.unavailableConference.includes(conference)) {
                return false;
            }
            return true
        },

        notAllowJoin() {
            return this.remainingConferences <= this.acceptedConferences.length
        }
    },
}
</script>

<style scoped>

</style>
