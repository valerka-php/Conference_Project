<template>
    <div class="map" id="map">

    </div>
</template>

<script>
import {isProxy, toRaw} from 'vue';

export default {
    props: {
        mapId: String,
    },

    data() {
        return {
            marker: null,
            location: {},
        }
    },

    methods: {
        createMap() {

            if (this.$store.getters.getCurrentCoordinates.lat !== null) {
                this.location = this.$store.getters.getCurrentCoordinates
            } else {
                this.location = this.$store.getters.getDefaultCoordinates
            }

            const map = new google.maps.Map(document.getElementById("map"), {
                center: this.location,
                zoom: 12,
                mapId: this.mapId,
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
        }
    },

    mounted() {


        this.createMap();

        this.$store.watch(
            () => {
                return this.$store.getters.getCurrentCoordinates;
            },
            (val) => {
                this.location.lng = val.lng === null ? this.location.lng : val.lng;
                this.location.lat = val.lat === null ? this.location.lat : val.lat;
                this.marker.setPosition(this.location);
            },
            {deep: true}
        );
    }
}
</script>

<style scoped>

</style>
