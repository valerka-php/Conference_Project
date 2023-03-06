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
                        <div class="filter-conference-date">
                            <div>
                                from
                            </div>
                            <input type="date" id="start" name="trip-start"
                                   v-model="form.date.min"
                                   :min="minDate" :max="maxDate">

                            <div>
                                to
                            </div>
                            <input type="date" id="start" name="trip-start"
                                   v-model="form.date.max"
                                   :min="form.date.min" :max="maxDate">
                        </div>

                        <div class="filter-count-report">
                            <Slider :max="this.maxReport" v-model="form.report_count"/>
                            <div>Report count</div>
                        </div>


                        <div class="filter-category-select mt-3">
                            <div> Select Category</div>
                            <v-row>
                                <v-col cols="12">
                                    <v-combobox
                                        v-model="selectedCategory"
                                        :items="items"
                                        :item-title="items.title"
                                        :item-value="items.id"
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
import Slider from '@vueform/slider'

export default {
    props: {
        categories: Object,
        maxReport: Number,
        minDate: String,
        maxDate: String,
    },

    components: {
        Slider
    },

    data() {
        return {
            dialog: false,
            file: null,
            selectedCategory: [],
            selectedCountReport: 0,
            form: {
                category_id: [],
                report_count: [0, this.maxReport],
                date: {
                    min: '',
                    max: '',
                }
            },
            items: [],
        }
    },

    methods: {
        submit() {
            this.selectedCategory.forEach(element => this.form.category_id.push(element.id))
            this.$inertia.get('/', this.form);
            this.form.category_id = [];
        },

        resetFilters() {
            this.$inertia.get('/');
        },

        resetDialog() {
            this.dialog = false
            this.file = null
        },
    },

    mounted() {
        Echo.private(`export-conference`)
            .listen('ConferenceExportDone', (e) => {
                this.file = e.fileName
            });

        for (let key in this.categories) {
            this.items.push(this.categories[key])
        }

        this.form.date.max = this.maxDate;
        this.form.date.min = this.minDate;
    }
}
</script>

<style src="@vueform/slider/themes/default.css"></style>
