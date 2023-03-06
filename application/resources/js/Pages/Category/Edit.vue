<template>
    <Head title="Edit Category"/>
    <ConferenceLayout/>

    <v-form
        ref="form"
        v-model="valid"
        lazy-validation
        class="category-form"
    >
        <InputLabel for="titleCategory" value="Title Category"/>

        <v-text-field
            id="titleCategory"
            v-model="form.title"
            :counter="25"
            :rules="titleRules"
            required
        ></v-text-field>
        <div class="mb-5" style="color: red" v-if="errors.title"> {{ errors.title }}</div>

        <div v-if="categories.length >= 1">
            <InputLabel for="parentCategory" value="Parent Category"/>

            <div class="parent-category-input">
                <v-select
                    id="parentCategory"
                    v-model="form.parent_category_id"
                    :items="categories"
                    item-value="id"
                    item-title="title"
                ></v-select>

                <button
                    v-if="form.parent_category_id !== null"
                    style="font-size: 35px;margin-bottom: 25px"
                    class="bi bi-x-lg"
                    @click.prevent="form.parent_category_id = null"
                >
                </button>
            </div>
        </div>

        <v-btn
            @click="save"
            :disabled="!valid"
            color="success"
            class="mr-4"
        >
            save
        </v-btn>
    </v-form>

</template>

<script>
import ConferenceLayout from "@/Layouts/HomeLayout.vue";
import {Head} from '@inertiajs/inertia-vue3';
import InputLabel from "@/Components/InputLabel.vue";

export default {
    name: "Edit",

    components: {
        InputLabel,
        ConferenceLayout,
        Head
    },

    props: {
        category: Object,
        errors: Object,
        categories: Array,
    },

    data() {
        return {
            form: {
                title: '',
                parent_category_id: null,
            },

            valid: true,
            titleRules: [
                value => !!value || 'Title is required',
                value => (value && value.length <= 25) || 'Title must be less than 25 characters',
                value => (value && value.length >= 2) || 'Title must be more than 2 characters',
            ],
        }
    },

    methods: {
        validate() {
            this.$refs.form.validate()
        },
        save() {
            if (confirm('Do you want save it?')) {
                this.$inertia.post(`/categories/${this.category.id}/update`, this.form)
            }
        },
    },

    mounted() {
        this.form.title = this.category.title
        this.form.parent_category_id = this.category.parent_category_id
    }
}
</script>

<style scoped>

</style>
