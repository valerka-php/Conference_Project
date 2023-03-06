<template>
    <Head title="Create Conference"/>
    <HomeLayout/>

    <div class="create-conference-form">
        <CreateMap :mapId="this.mapId" class="mb-7 mt-4 mr-4 ml-4"/>

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
                        id="title"
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
                        v-model="form.date"
                        :rules="dateRules"
                        placeholder="dd-mm-yyyy"
                        required
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
                    <BackButton class="ml-5 btn-conference">

                    </BackButton>

                    <v-btn
                        @click="validate"
                        color="success"
                        class="mr-4"
                    >
                        create
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

export default {
    components: {
        HomeLayout,
        BackButton,
        Link,
        Head,
        CreateMap
    },

    props: {
        countries: Array,
        errors: Object,
        userId: Number,
        mapId: String,
        categories: Object,
    },

    data: () => ({
        valid: true,
        titleRules: [
            value => !!value || 'Name is required',
            value => (value && value.length <= 25) || 'Name must be less than 25 characters',
            value => (value && value.length >= 2) || 'Name must be more than 2 characters',
        ],
        dateRules: [
            value => !!value || 'Please select date',
        ],
        latitudeRules: [
            value => (value && value >= -90 && value <= 90 || value === 0) || 'point must be in the range [-90 , 90]',
        ],
        longitudeRules: [
            value => (value && value >= -180 && value <= 180 || value === 0) || 'point must be in the range [-180 , 180]',
        ],
        form: {
            title: '',
            date: '',
            latitude: '',
            longitude: '',
            country: 'Ukraine',
            category_id: '',
        }
    }),

    methods: {
        async validate() {
            const {valid} = await this.$refs.form.validate()

            if (valid) this.submit()
        },
        submit() {
            this.getCoordinates()
            this.$inertia.post('/conferences', this.form)
        },

        getCoordinates() {
            this.form.latitude = this.$store.getters.getCurrentLatitude
            this.form.longitude = this.$store.getters.getCurrentLongitude
        },

    },

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
}

</script>

<style scoped>

</style>
