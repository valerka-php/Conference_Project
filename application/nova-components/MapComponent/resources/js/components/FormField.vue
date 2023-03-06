<template>
    <DefaultField
        :field="field"
        :errors="errors"
        :show-help-text="showHelpText"
        :full-width-content="fullWidthContent"
    >
        <template #field>
            <div class="map" id="map" style="z-index: 1000;width: 500px;height: 500px"></div>
            <div class="flex">
                <div class="w-1/2 mr-6">
                    <p class="mb-1">Latitude</p>
                    <input
                        type="number"
                        step="any"
                        class="w-full form-control form-input form-input-bordered"
                        :class="errorClasses"
                        v-model="location.lat"
                    />
                </div>
                <div class="w-1/2">
                    <p class="mb-1">Longitude</p>
                    <input
                        type="number"
                        step="any"
                        class="w-full form-control form-input form-input-bordered"
                        :class="errorClasses"
                        v-model="location.lng"
                    />
                </div>
            </div>
        </template>
    </DefaultField>
</template>

<script>
import {FormField, HandlesValidationErrors} from 'laravel-nova'
import {isProxy, toRaw} from "vue";
import {Loader} from '@googlemaps/js-api-loader';

export default {
    mixins: [FormField, HandlesValidationErrors],

    props: ['resourceName', 'resourceId', 'field'],

    data() {
        return {
            google: null,
            marker: null,
            location: {},
        }
    },

    methods: {
        /*
         * Set the initial, internal value for the field.
         */
        setInitialValue() {
            this.value = this.field.value || ''
        },

        /**
         * Fill the given FormData object with the field's internal value.
         */
        fill(formData) {
            formData.append(this.field.attribute + '[latitude]', this.location.lat)
            formData.append(this.field.attribute + '[longitude]', this.location.lng)
        },

        createMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                center: this.location,
                zoom: 12,
                mapId: this.field.mapId,
            });

            this.marker = this.addMarker(this.location, map);

            if (isProxy(this.marker)) {
                this.marker = toRaw(this.marker)
            }

            google.maps.event.addListener(map, 'click', (event) => {
                this.location = event.latLng.toJSON();
                if (this.marker) {
                    toRaw(this.marker).setMap(null)
                }
                this.marker = this.addMarker(toRaw(this.location), map)
                this.saveCoordinates(toRaw(this.location));
            })
        },

        saveCoordinates(location) {
            this.$store.commit("saveCoordinates", location);
        },

        addMarker(location, map) {
            return new google.maps.Marker({
                position: location,
                map: map
            });
        },
    },

    async mounted() {
        const googleMapApi = await new Loader({
            apiKey: "AIzaSyB-RGE9A0mImqPTQCZoX-R0SW1v9wl1gpo",
        })

        this.google = await googleMapApi.load();

        this.google = window.google;

        this.location.lat = this.field.latitude
        this.location.lng = this.field.longitude

        this.createMap()
    },
}
</script>


