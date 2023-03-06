<template>
    <div
        class="flex flex-col md:flex-row -mx-6 px-6 py-2 md:py-0 space-y-2 md:space-y-0"
        :class="{
            'border-t border-gray-100 dark:border-gray-700': index !== 0
        }"
    >
        <div class="md:w-1/4 md:py-3">
            <slot>
                <h4 class="md:font-normal">
                    <span>{{ this.field.name }}</span>
                </h4>
            </slot>
        </div>
        <div class="md:w-3/4 md:py-3 break-words">
            <slot name="value">
                <span>{{ field.latitude + ', ' + field.longitude }}</span>
                <div id="map" style="z-index: 1000;width: auto;height: 350px">

                </div>
            </slot>
        </div>
    </div>
</template>

<script>
import {isProxy, toRaw} from "vue";
import {Loader} from "@googlemaps/js-api-loader";

export default {
    props: ['index', 'resource', 'resourceName', 'resourceId', 'field'],

    data() {
        return {
           location:{
               lat:'',
               lng:''
           }
        }
    },

    methods: {
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

        addMarker(location, map) {
            return new google.maps.Marker({
                position: location,
                map: map
            });
        },
    },

    async mounted() {
        const googleMapApi = await new Loader({
            apiKey: this.field.apiKey,
        })

        this.google = await googleMapApi.load();

        this.google = window.google;

        this.location.lat = this.field.latitude
        this.location.lng = this.field.longitude

        this.createMap()
    }
}
</script>
