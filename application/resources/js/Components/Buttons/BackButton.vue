<template>
    <Link
        @click="back"
        class="btn btn-outline-secondary"
    >
        back
    </Link>
</template>


<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    name: "BackButton",

    components:{
        Link,
    },

    methods:{
        back() {
            window.history.back();
        },
    }
}
</script>

<style scoped>

</style>
