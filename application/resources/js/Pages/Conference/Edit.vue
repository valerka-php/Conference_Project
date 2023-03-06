<template>
    <Head title="Edit Conference"/>
    <HomeLayout/>

    <div class="create-conference-form">
        <CreateMap class="mb-7 "/>

        <div class="mb-7">
            <v-form
                ref="form"
                v-model="valid"
                lazy-validation
                style="width: 360px;"
                class="mt-5"
            >
                <!-- Title-->
                <div>
                    <v-text-field
                        v-model="form.title"
                        :counter="25"
                        :rules="titleRules"
                        label="Title"
                        required
                    ></v-text-field>
                    <div class="mb-5" v-if="errors.title"> {{ errors.title }}</div>
                </div>

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

                <!-- Date -->
                <div>
                    <v-text-field
                        type="date"
                        :rules="dataRules"
                        v-model="form.date"
                        placeholder="dd-mm-yyyy"
                    />
                </div>

                <!-- Latitude -->
                <div>
                    <v-text-field
                        :rules="latitudeRules"
                        v-model="lat"
                        type="number"
                        label="Latitude"
                    />
                </div>

                <!-- Longitude -->
                <div>
                    <v-text-field
                        :rules="longitudeRules"
                        v-model="lng"
                        type="number"
                        label="Longitude"
                    />
                </div>

                <!-- Country -->
                <div>
                    <v-select
                        v-model="form.country"
                        :items="countries"
                        item-value="name"
                        item-title="name"
                        label="Country"
                        required
                    />
                </div>

                <div class="register-form-footer">
                    <BackButton class="ml-5 btn-conference"></BackButton>

                    <v-btn
                        @click="submit"
                        color="success"
                        class="mr-4"
                    >
                        save
                    </v-btn>
                </div>
            </v-form>
        </div>
    </div>
</template>

<script>
import {Link, Head} from '@inertiajs/inertia-vue3';
import CreateMap from "@/Pages/Map/CreateMap.vue";
import BackButton from "@/Components/Buttons/BackButton.vue";
import HomeLayout from "@/Layouts/HomeLayout.vue";
import {toRaw} from "vue";

export default {
    components: {
        Link,
        Head,
        CreateMap,
        BackButton,
        HomeLayout
    },

    props: {
        countries: Array,
        errors: Object,
        conference: Object,
        categories: Object,
    },

    data: () => ({
        valid: true,
        titleRules: [
            value => !!value || 'Name is required',
            value => (value && value.length <= 25) || 'Name must be less than 25 characters',
            value => (value && value.length >= 2) || 'Name must be more than 2 characters',
        ],
        dataRules: [
            value => !!value || 'Please select date',
        ],
        latitudeRules: [
            value => (value && value >= -90 && value <= 90 || value === 0) || 'point must be in the range [-90 , 90]',
        ],
        longitudeRules: [
            value => (value && value >= -180 && value <= 180 || value === 0) || 'point must be in the range [-180 , 180]',
        ],
        form: {
            id: '',
            title: '',
            date: '',
            latitude: '',
            longitude: '',
            country: '',
            category_id: '',
        },
    }),

    computed: {
        lat: {
            get() {
                return this.$store.getters.getCurrentLatitude
            },
            set(value) {
                this.$store.commit('saveLatitude', parseFloat(value))
            }
        },
        lng: {
            get() {
                return this.$store.getters.getCurrentLongitude
            },
            set(value) {
                this.$store.commit('saveLongitude', parseFloat(value))
            }
        }
    },

    methods: {
        async validate() {
            const {valid} = await this.$refs.form.validate()

            if (valid) this.submit()
        },
        submit() {
            this.getCoordinates()
            this.$inertia.put(`/conferences/${this.form.id}`, this.form)
        },

        getCoordinates() {
            this.form.latitude = this.$store.getters.getCurrentLatitude
            this.form.longitude = this.$store.getters.getCurrentLongitude
        },
    },

    mounted() {
        this.form.title = this.conference.title
        this.form.id = this.conference.id
        this.form.creator_id = this.conference.creator_id
        this.form.date = this.conference.date.substring(0,10)
        this.form.country = this.conference.country
        this.form.latitude = this.conference.latitude
        this.form.longitude = this.conference.longitude
        this.form.category_id = this.conference.category_id

        this.$store.commit(
            "saveCoordinates",
            {
                lat: parseFloat(this.form.latitude),
                lng: parseFloat(this.form.longitude)
            }
        );
    }
}
</script>

<style scoped>

</style>
