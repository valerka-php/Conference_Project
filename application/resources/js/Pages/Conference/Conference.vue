<template>
    <Head title="Conference"/>
    <ConferenceLayout/>

    <v-breadcrumbs
        :items="array"
        divider="/"
    ></v-breadcrumbs>

    <div class="conference-show ">
        <Map
            :latitude="conference.latitude"
            :longitude="conference.longitude"
            :mapId="mapId"
            class="mb-7 ml-4 mr-10"
        />

        <div class="mb-7">
            <div class="conference-detail">

                <!-- Title -->
                <div class="conference-field pl-8">{{ conference.title }}</div>

                <!-- Date -->
                <div class="conference-field ">
                    <div><i class="bi bi-calendar-event"></i></div>
                    <div> {{ conference.date.substring(0,10) }}</div>
                </div>

                <!-- latitude -->
                <div class="conference-field">
                    <div><i class="bi bi-geo-alt"></i></div>
                    <div>{{ conference.latitude }}</div>
                </div>


                <!-- longitude -->
                <div class="conference-field">
                    <div><i class="bi bi-geo-alt-fill"></i></div>
                    <div>{{ conference.longitude }}</div>
                </div>


                <!-- Country -->
                <div class="conference-field">
                    <div><i class="bi bi-globe-americas"></i></div>
                    <div>{{ conference.country }}</div>
                </div>
            </div>

            <div class="conference-show-footer">
                <div>
                    <Link :href="'/'" class="btn btn-outline-secondary btn-conference"> back</Link>
                </div>
                <div v-if="canEdit()">
                    <EditButton
                        :conference-id="conference.id"
                        @click="saveCoordinates"
                    ></EditButton>
                </div>
                <div v-if="canEdit()">
                    <DeleteButton :id="conference.id"></DeleteButton>
                </div>
            </div>

            <Link
                :href="route('reports.show',{ conference:conference.id })"
                class="w-full mt-4 btn btn-outline-primary btn-join"
            >
                Reports
            </Link>

            <div
                class="conference-leave-footer "
                v-if="canLeave"
            >
                <LeaveButton
                    :user="user"
                    :conference-id="conference.id"
                    :title-conference="conference.title"
                    class="w-full mt-4"
                />

                <SocialMedia
                    :url="`${this.shareUrl + conference.id}`"
                    :text="`${this.shareText}`"
                />
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
</template>

<script>
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import Map from "@/Pages/Map/Map.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
import EditButton from "@/Pages/Conference/Buttons/EditButton.vue";
import DeleteButton from "@/Pages/Conference/Buttons/DeleteButton.vue";
import {ShareNetwork} from "vue-social-sharing/src/vue-social-sharing";
import LeaveButton from "@/Pages/Conference/Buttons/LeaveButton.vue";
import SocialMedia from "@/Pages/Conference/Buttons/SocialMedia.vue";
import {Head, Link} from '@inertiajs/inertia-vue3';
import axios from "axios";

export default {
    name: "Conference",

    components: {
        LeaveButton,
        Map,
        ConferenceLayout,
        BackButton,
        EditButton,
        Link,
        DeleteButton,
        ShareNetwork,
        SocialMedia,
        Head
    },

    data() {
        return {
            dialog: false,
            file: null,
            array: [],
        }
    },

    props: {
        conference: Object,
        mapId: String,
        user: Object,
        shareUrl: String,
        shareText: String,
        canLeave: Boolean,
        breadcrumbs: Array,
    },

    methods: {
        saveCoordinates() {
            this.$store.commit(
                'saveCoordinates',
                {
                    lat: parseFloat(this.conference.latitude),
                    lng: parseFloat(this.conference.longitude),
                }
            );
        },

        canEdit() {
            if (this.isCreator() || this.isAdmin()) {
                return true;
            }
            return false;
        },

        isCreator() {
            return this.$page.props.auth.user.id === this.conference.creator_id
        },

        isAdmin() {
            return this.$page.props.auth.isAdmin
        },

        setBreadcrumbItems(array) {
            this.array.unshift({
                title: array.title,
                href: `/conferences/category/${array.id}`,
            });

            if (array.parents) {
                this.setBreadcrumbItems(array.parents)
            }
        },

        exportReports() {
            this.dialog = true

            axios.get(`/reports/${this.conference.id}/export/csv`)
        },

        exportUserListeners() {
            this.dialog = true

            axios.get(`/users/${this.conference.id}/export/csv`)
        },

        resetDialog() {
            this.dialog = false
            this.file = null
        }
    },

    mounted() {
        Echo.private(`export-reports`)
            .listen('ReportExportDone', (e) => {
                this.file = e.fileName
            });

        Echo.private(`export-user-listener`)
            .listen('UserListenerExportDone', (e) => {
                this.file = e.fileName
            });

        if (this.breadcrumbs['parents']) {
            this.setBreadcrumbItems(this.breadcrumbs['parents'])
        }

        this.array.unshift({
            title: 'Conferences',
            href: '/',
        })

        this.array.push({
            title: this.breadcrumbs.child.title,
            href: `/conferences/category/${this.breadcrumbs.child.id}`,
        })
    }
}
</script>
