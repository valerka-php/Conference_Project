<template>
    <Link
        @click="deleteConference(id)"
        class="btn btn-outline-danger btn-conference"
    >
        delete
    </Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "DeleteButton",

    components: {
        Link
    },

    props: {
        id: Number,
    },

    methods: {
        deleteConference(id) {
            if (confirm('Do you want delete it?')) {
                this.$inertia.delete(`/conferences/${id}`)
            }
        }
    },

}
</script>

<style scoped>

</style>
