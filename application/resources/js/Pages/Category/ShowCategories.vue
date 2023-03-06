<template>
    <Head title="Category"/>
    <ConferenceLayout/>

    <div class="category-show">
        <create-category-button class="mb-4"/>

        <v-card
            class="mx-auto"
            width="auto"
        >

            <v-list>
                <TreeComponent v-for="item in categoriesTree" :categories="item"></TreeComponent>
            </v-list>

        </v-card>
    </div>
</template>

<script>
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import {Head} from '@inertiajs/inertia-vue3';
import CreateCategoryButton from "@/Components/Buttons/Admin/CreateCategoryButton.vue";
import TreeComponent from "@/Pages/Category/Items/TreeComponent.vue";


export default {
    name: "Show",

    components: {
        TreeComponent,
        ConferenceLayout,
        Head,
        CreateCategoryButton,
    },

    props: {
        categoriesTree: Object,
    },
}
</script>

<style scoped>

</style>
