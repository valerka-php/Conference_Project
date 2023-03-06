<template>
    <div class="map" id="map">

    </div>
</template>

<script>
export default {
    name: "Map",

    props: {
        latitude: String,
        longitude: String,
        mapId: String,
    },

    methods: {
        initMap() {
            const uluru = {lat: parseFloat(this.latitude), lng: parseFloat(this.longitude)}

            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 13,
                center: uluru,
                mapId: this.mapId,
            });

            const marker = new google.maps.Marker({
                position: uluru,
                map: map,
            });
        }
    },

    mounted() {
        this.initMap()
    }

}
</script>

<style scoped>

</style>
