<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div class="report-time">
                <div class="set-time">
                    <Datepicker
                        placeholder="Select Start Time"
                        :min-time="{ hours: 8 }"
                        :max-time="{ hours: 21 }"
                        v-model="start"
                        minutes-increment="15"
                        minutes-grid-increment="15"
                        time-picker
                    />

                    <Datepicker
                        placeholder="Select End Time"
                        :min-time="{ hours: 8 }"
                        :max-time="{ hours: 21 }"
                        v-model="end"
                        minutes-increment="15"
                        minutes-grid-increment="15"
                        time-picker
                    />
                </div>
                <div class="error-form" v-if="errors.error"> {{ errors.error }}</div>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import Datepicker from '@vuepic/vue-datepicker';

export default {
    mixins: [FormField, HandlesValidationErrors],

    components: {
        Datepicker
    },

    props: ['resourceName', 'resourceId', 'field'],

    methods: {
        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute + '[start_time]', this.getStartTime())
            formData.append(this.field.attribute + '[end_time]', this.getEndTime())
        },

        getStartTime() {
            return `${this.start.hours}:${this.start.minutes}:${this.start.seconds}`
        },
        getEndTime() {
            return `${this.end.hours}:${this.end.minutes}:${this.end.seconds}`
        },
    },

    data() {
        return {
            start: {},
            end: {},
        }
    },

    mounted() {
        this.start = {
            hours: this.field.start_time.substring(0, 2),
            minutes: this.field.start_time.substring(3, 5),
            seconds: 0,
        };

        this.end = {
            hours: this.field.end_time.substring(0, 2),
            minutes: this.field.end_time.substring(3, 5),
            seconds: 0,
        }
    }
}
</script>
