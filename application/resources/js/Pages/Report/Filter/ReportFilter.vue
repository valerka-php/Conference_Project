<template>
    <div class="accordion" id="accordionExample">
        <div class="accordion-item">
            <div id="headingOne" class="conference-filter-icon">
                <button class="bi bi-funnel" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne"
                        aria-expanded="true" aria-controls="collapseOne">
                </button>
            </div>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne"
                 data-bs-parent="#accordionExample">
                <div class="accordion-body">
                    <v-container class="filter-form">
                        <div class="filter-report-set-time">
                            <div>from</div>
                            <Datepicker
                                v-model="this.time"
                                :min-time="{ hours: 8 }"
                                :max-time="{ hours: 21 }"
                                minutes-increment="15"
                                minutes-grid-increment="15"
                                time-picker
                                range
                            />
                            <div>to</div>
                        </div>

                        <div class="filter-report-time mt-3">
                            <div>
                                Select report time
                            </div>
                            <div style="display: flex">
                                <input
                                    type="range"
                                    class="form-range"
                                    v-model="report_time"
                                    min="15"
                                    max="60"
                                    step="15"
                                >
                                <div>
                                    {{ report_time }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3">
                            <v-row>
                                <v-col cols="12">
                                    <v-combobox
                                        v-model="selectedCategory"
                                        :items="categories"
                                        label="Select Category"
                                        multiple
                                        chips
                                        variant="solo"
                                    >
                                    </v-combobox>
                                </v-col>
                            </v-row>
                        </div>

                        <div class="filter-form-footer">
                            <div>
                                <v-btn @click="submit">
                                    filter
                                </v-btn>
                            </div>

                            <div>
                                <v-btn @click="resetFilters">
                                    reset filters
                                </v-btn>
                            </div>
                        </div>


                    </v-container>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';

export default {


    components: {
        Datepicker,
    },

    props: {
        categories: Object,
        conferenceId: Number,
    },

    data() {
        return {
            time: '',
            report_time: '15',
            selectedCategory: [],
            form: {
                conference_id: 41,
                report_time: '',
                category_id: [],
            },
        }
    },

    methods: {
        submit() {
            this.selectedCategory.forEach(element => this.form.category_id.push(element.id))
            this.getTime()
            this.form.report_time = this.timeConvert(this.report_time)

            this.$inertia.get(`/reports/${this.conferenceId}`, this.form);

            this.form.category_id = [];
        },

        getTime() {
            if (this.time) {

                let selectedTime = {
                    period_of_time: {
                        start_time: this.time[0].hours + ':' + this.time[0].minutes,
                        end_time: this.time[1].hours + ':' + this.time[1].minutes,
                    }
                }

                Object.assign(this.form, selectedTime)
            }
        },

        timeConvert(minutes) {
            if (parseInt(minutes) < 60) {
                return `00:${minutes}:00`
            }
            return "01:00:00"
        },

        resetFilters() {
            this.$inertia.get(`/reports/${this.conferenceId}`);
        }
    },
}
</script>

<style scoped>

</style>
