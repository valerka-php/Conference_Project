<template>
    <div class="category-edit">
        <button class="bi bi-pencil-square mr-4" @click.prevent="update"></button>

        <button class="bi bi-trash mr-4" @click.prevent="destroy"></button>
    </div>
</template>

<script>
export default {
    name: "EditButton",

    props: {
        id: Number,
    },

    methods: {
        destroy() {
            if (confirm('Do you want delete it?')) {
                this.$inertia.delete(`/categories/${this.id}`,)
            }
        },

        update() {
            this.$inertia.get(`/categories/${this.id}/edit`,)
        },
    },
}
</script>

<style scoped>

</style>
