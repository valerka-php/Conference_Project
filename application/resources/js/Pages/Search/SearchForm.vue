<template>
    <form class="d-flex search-form" role="search">
        <div class="search-form-input">
            <input class="form-control" v-model="form.title">
            <v-btn
                @click.prevent="search"
                color="success"
            >
                search
            </v-btn>
        </div>

        <div class="error-form" v-if="$page.props.errors.title"> {{ $page.props.errors.title }}</div>
        <div class="error-form" v-if="$page.props.errors.checkbox"> {{ $page.props.errors.checkbox }}</div>

        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" @click="selectConference" type="checkbox">
                <label class="form-check-label" for="inlineCheckbox1">Conference</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" @click="selectReport" type="checkbox">
                <label class="form-check-label" for="inlineCheckbox1">Report</label>
            </div>
        </div>
    </form>
</template>

<script>
export default {
    name: "Form",

    props: {
        errors: Object,
    },

    data() {
        return {
            form: {
                title: '',
                checkbox: {},
            }
        }
    },

    methods: {
        search() {
            this.$inertia.get(`/search`, this.form)
        },

        selectConference() {
            if (this.form.checkbox.conference) {
                delete this.form.checkbox.conference
            } else {
                this.form.checkbox.conference = 1
            }
        },

        selectReport() {
            if (this.form.checkbox.report) {
               delete this.form.checkbox.report
            } else {
                this.form.checkbox.report = 1
            }
        }
    },
}
</script>

<style scoped>

</style>
