<template>
    <v-list-group :value="categories.title" v-if="categories.children.length > 0">
        <template v-slot:activator="{ props }">
            <div class="category-item">
                <v-list-item
                    style="width:350px"
                    class="category-items"
                    v-bind="props"
                >
                    {{ categories.title }}
                    <v-badge
                        v-if="categories.count_conferences >= 1"
                        inline
                        color="green"
                        :content="categories.count_conferences"
                    />
                    <v-badge
                        v-if="categories.count_reports >= 1"
                        inline
                        color="orange"
                        :content="categories.count_reports"
                    />
                </v-list-item>

                <EditButton :id="categories.id"/>
            </div>
        </template>

        <div v-if="categories.children">
            <TreeComponent v-for="child in categories.children" :categories="child"></TreeComponent>
        </div>

    </v-list-group>

    <div class="category-item" v-else>
        <v-list-item
            style="width:350px"
            class="category-items"
            v-bind="props"
        >
            {{ categories.title }}
            <v-badge
                v-if="categories.count_conferences >= 1"
                inline
                color="green"
                :content="categories.count_conferences"
            />
            <v-badge
                v-if="categories.count_reports >= 1"
                inline
                color="orange"
                :content="categories.count_reports"
            />
        </v-list-item>

        <EditButton :id="categories.id"/>
    </div>

</template>

<script>
import EditButton from "@/Pages/Category/Buttons/EditButton.vue";

export default {
    name: "TreeComponent",

    components: {EditButton},

    props: {
        categories: Object,
    }
}
</script>

<style scoped>

</style>
