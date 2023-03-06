<template>
    <Link
        :href="route('conferences.edit',{ conference: this.conferenceId })"
        class="btn btn-outline-warning btn-conference"
    >
        EDIT
    </Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "EditButton",

    components: {
        Link,
    },

    props: {
        conferenceId: Number,
    },
}
</script>

<style scoped>

</style>
