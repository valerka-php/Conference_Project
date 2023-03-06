<template>
    <Head title="Report"/>
    <ConferenceLayout/>

    <v-form
        ref="form"
        class="report-create"
        v-model="valid"
        lazy-validation
    >
        <!-- Title -->

        <v-text-field
            label="Title"
            :rules="titleRules"
            v-model="form.title"
        />
        <div class="error-form" v-if="errors.title"> {{ errors.title }}</div>

        <!-- Category -->

        <div>
            <v-select
                v-model="form.category_id"
                :items="categories"
                item-value="id"
                item-title="title"
                label="Category"
                required
            />
            <div class="mb-5 errors" v-if="errors.category_id"> {{ errors.category_id }}</div>
        </div>

        <!-- Date picker -->

        <div class="report-time">
            <div class="set-time">
                <Datepicker
                    placeholder="Select Start Time"
                    :min-time="{ hours: 8 }"
                    :max-time="{ hours: 21 }"
                    v-model="startTime"
                    minutes-increment="15"
                    minutes-grid-increment="15"
                    time-picker
                />

                <Datepicker
                    placeholder="Select End Time"
                    :min-time="{ hours: 8 }"
                    :max-time="{ hours: 21 }"
                    v-model="endTime"
                    minutes-increment="15"
                    minutes-grid-increment="15"
                    time-picker
                />
            </div>
            <div class="error-form" v-if="errors.time"> {{ errors.time }}</div>
        </div>

        <!-- Description -->

        <v-textarea
            class="mt-7"
            solo
            name="input-7-4"
            :rules="descriptionRules"
            v-model="form.description"
            label="Description"
        ></v-textarea>

        <div class="error-form" v-if="errors.description"> {{ errors.description }}</div>

        <div class="report-presentation">
            <i class="bi bi-file-text" style="font-size: 45px"></i>
            <v-file-input
                label="File input"
                variant="solo"
                :rules="fileRules"
                v-model="presentation"
            />
        </div>

        <div class="form-check form-switch">
            <input
                class="form-check-input"
                type="checkbox"
                role="switch"
                id="flexSwitchCheckDefault"
                v-model="form.online"
            >
            <label class="form-check-label" for="flexSwitchCheckDefault">online</label>
        </div>

        <div class="register-form-footer">
            <BackButton
                class="v-btn v-btn--elevated v-theme--light  v-btn--density-default v-btn--size-default v-btn--variant-elevated ml-4"/>

            <v-btn
                @click="validate"
                color="success"
                class="mr-4"
            >
                save
            </v-btn>
        </div>
    </v-form>
</template>

<script>
import {Head, Link} from '@inertiajs/inertia-vue3';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import BackButton from "@/Components/Buttons/BackButton.vue";
import {toRaw} from "vue";
import ConferenceLayout from "@/Layouts/HomeLayout.vue";

export default {
    name: "CreateReport",

    props: {
        conferenceId: Number,
        date: String,
        errors: Object,
        categories: Object,
    },

    components: {
        ConferenceLayout,
        BackButton,
        Datepicker,
        Head,
        Link,
    },

    data() {
        return {
            valid: true,
            titleRules: [
                value => !!value || 'Name is required',
                value => (value && value.length <= 255) || 'Name must be less than 255 characters',
                value => (value && value.length >= 2) || 'Name must be more than 2 characters',
            ],
            descriptionRules: [
                value => (value && value.length <= 255) || 'Name must be less than 255 characters',
            ],
            fileRules: [
                value => !!value || 'Please add your presentation',
                value => (toRaw(value[0].size <= 1e+7)) || 'Size must be less then 10 mb',
                value => (this.getFileType(value) === 'pptx' || this.getFileType(value) === 'ppt') || 'File must be pptx or ppt',
            ],
            form: {
                title: '',
                description: '',
                startTime: '',
                endTime: '',
                category_id: '',
                online: false,
            },
            presentation: '',
            startTime: {
                hours: 8,
                minutes: 0,
                seconds: 0,
            },
            endTime: {
                hours: 9,
                minutes: 0,
                seconds: 0,
            },
        }
    },

    methods: {
        async validate() {
            const {valid} = await this.$refs.form.validate()

            if (valid) this.submit()
        },

        submit() {
            this.getTime()

            this.$inertia.post(`/reports/${this.conferenceId}`, {
                online: this.form.online,
                conference_id: this.conferenceId,
                title: this.form.title,
                description: this.form.description,
                start_time: this.form.startTime,
                end_time: this.form.endTime,
                category_id: this.form.category_id,
                file: this.presentation
            }, {forceFormData: true})
        },

        getTime() {
            this.form.startTime = this.startTime.hours + ':' + this.startTime.minutes;
            this.form.endTime = this.endTime.hours + ':' + this.endTime.minutes;
        },

        getFileType(file) {
            let extensionStart = file[0].name.lastIndexOf('.') + 1;
            let fileNameLength = file[0].name.length;

            return file[0].name.substring(extensionStart, fileNameLength);
        },
    },
}
</script>

<style scoped>

</style>
