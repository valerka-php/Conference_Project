<template>
    <span
        class="badge"
        :class="{
            'text-bg-danger' : status === 'completed',
            'text-bg-success' : status === 'online',
            'text-bg-warning' : status === 'waiting'
        }"
    >{{ status }}</span>
    <v-card class="mx-auto">
        <div class="card-report-title">
            <Link
                class="v-card-title"
                :href="route('report.home',{ id:report.id })"
            >{{ report.title }}
            </Link>

            <div v-if="report.comments_count >= 1">
                <v-badge :content="report.comments_count"><i class="bi bi-chat-square-text comment-badge"></i></v-badge>
            </div>

            <div style="margin-left: 35px;">
                <button
                    class="bi add-favorite"
                    :class="{ 'bi-star': !isFavorite , 'bi-star-fill': isFavorite}"
                    @click="addToFavorite"
                />
            </div>
        </div>
        <div class="card-report-time">
            {{ report.start_time.substring(0, 5) + ' - ' + report.end_time.substring(0, 5) }}
        </div>

        <v-card-subtitle>
            {{ report.description.length < 100 ? report.description : report.description.substring(0, 100) + '...' }}
        </v-card-subtitle>

        <div class="countdown" v-if="report.online">
            <div class="link-zoom" v-if="minuteToStart > 10">
                <Countdown :deadlineISO="this.getStartTime()"/>
            </div>
            <div v-else-if="minuteToStart <= 10 && !expired" class="link-zoom">
                <div v-if="$page.props.user.id === report.creator_id">
                    <Link
                        :href="report.start_url"
                    >
                        start zoom meeting
                    </Link>
                </div>
                <div v-else-if="acceptedConference">
                    <Link
                        :href="report.join_url"
                    >
                        join to zoom meeting
                    </Link>
                </div>
            </div>
            <div v-else-if="expired" class="link-zoom">
                report ended
            </div>
        </div>

        <div v-if="report.description.length > 100">
            <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn
                    :icon="show ? 'bi bi-chevron-up' : 'bi bi-chevron-down'"
                    @click="show = !show"
                ></v-btn>
            </v-card-actions>

            <v-expand-transition>
                <div v-show="show">
                    <v-divider></v-divider>

                    <v-card-text>
                        {{ report.description }}
                    </v-card-text>
                </div>
            </v-expand-transition>
        </div>
        <div v-else class="card-action"></div>
    </v-card>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';
import {Countdown} from 'vue3-flip-countdown';

export default {
    name: "Card",

    components: {
        Link,
        Countdown
    },

    props: {
        acceptedConference: Boolean,
        report: Object,
        conferenceId: Number,
        startDate: String,
    },

    data: () => ({
        status: 'waiting',
        expired: false,
        minuteToStart: 0,
        show: false,
        isFavorite: false,
    }),

    methods: {
        addToFavorite() {
            this.isFavorite = !this.isFavorite

            if (this.isFavorite) {
                this.$store.commit("addToFavorites", this.report.id);
                this.$inertia.post(`/favorite/${this.report.id}`)
            } else {
                this.$store.commit("removeFromFavorites", this.report.id);
                this.$inertia.delete(`/favorite/${this.report.id}`)
            }
        },

        checkFavorite() {
            if (this.$store.getters.getFavorite.find(element => element === this.report.id)) {
                return this.isFavorite = true;
            }
            return this.isFavorite = false;
        },

        getStartTime() {
            return `${this.startDate.substring(0,10)}T${this.report.start_time}`;
        },

        getEndTime() {
            return `${this.startDate.substring(0,10)}T${this.report.end_time}`;
        },

        diffMinutes() {
            const currentTime = new Date(Date.now()).getTime();
            const startTime = new Date(this.getStartTime()).getTime();
            this.minuteToStart = Math.round((startTime - currentTime) / 60000)

            if (this.minuteToStart <= 0 && !this.expired) {
                this.status = 'online'
                clearInterval(this.diffMinutes)
            } else if (this.minuteToStart <= 0 && this.expired) {
                this.status = 'completed'
                clearInterval(this.diffMinutes)
            } else {
                this.status = 'waiting'
            }
        },

        startTimer() {
            const currentTime = new Date(Date.now()).getTime();
            const startTime = new Date(Date.parse(this.getStartTime())).getTime();

            this.minuteToStart = Math.round((startTime - currentTime) / 60000)

            setInterval(this.diffMinutes, 1000)
        },

        checkReportOnline() {
            const currentTime = new Date(Date.now()).getTime();
            const startTime = new Date(Date.parse(this.getStartTime())).getTime();

            if (currentTime > startTime && !this.expired) {
                this.status = 'online';
            }
        },

        checkReportEndTime() {
            const currentTime = new Date(Date.now()).getTime();
            const endTime = new Date(`${this.startDate.substring(0,10)} ${this.report.end_time}`).getTime();

            if (currentTime >= endTime) {
                this.expired = true;
                this.status = 'completed';
            }
        }
    },

    mounted() {
        this.startTimer()
        this.checkFavorite()
        this.checkReportOnline()
        this.checkReportEndTime()
    }
}
</script>

<style scoped>

</style>
