<script setup>
import HomeLayout from "@/Layouts/HomeLayout.vue";
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import {Head} from '@inertiajs/inertia-vue3';

defineProps({
    mustVerifyEmail: Boolean,
    status: Boolean,
    countries: Array,
    userCreditBalance: String,
    subscriptions: Object,
});
</script>

<template>
    <Head title="Profile"/>

    <HomeLayout/>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <ul class="list-group">
                    <li class="list-group-item active" aria-current="true">Current plans:</li>
                    <li
                        v-for="subscription in  subscriptions"
                        class="list-group-item profile-plans-list"
                    >
                        <div>{{ subscription.name }}</div>
                        <v-btn
                            v-if="subscription.name !== 'free'"
                            :href="route('subscription.cancel',{ plan: subscription.name })"
                        > unsubscribe
                        </v-btn>
                    </li>
                </ul>
                <ul class="list-group mt-5">
                    <li class="list-group-item">Credit Balance {{ userCreditBalance }}</li>
                </ul>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    :countries="countries"
                    class="max-w-xl"
                />
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdatePasswordForm class="max-w-xl"/>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <DeleteUserForm class="max-w-xl"/>
            </div>
        </div>
    </div>
</template>
