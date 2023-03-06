<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm, usePage} from '@inertiajs/inertia-vue3';

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    countries: Array,
});

const user = usePage().props.value.auth.user;

const form = useForm({
    firstname: user.firstname,
    lastname: user.lastname,
    country_id: user.country_id,
    birthdate: user.birthdate,
    phone: user.phone,
    email: user.email,
});

const rules = {
    phone: [
        (value) => (value && value.length >= 10) || 'minimum 10 characters',
    ],
}
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-6">
            <div class="profile-form-input">
                <InputLabel for="firstname" value="First Name"/>

                <TextInput
                    id="firstname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.firstname"
                    required
                    autocomplete="firstname"
                />

                <InputError class="mt-2" :message="form.errors.firstname"/>
            </div>

            <div class="profile-form-input">
                <InputLabel for="lastname" value="Last Name"/>

                <TextInput
                    id="lastname"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.lastname"
                    required
                    autocomplete="lastname"
                />

                <InputError class="mt-2" :message="form.errors.lastname"/>
            </div>

            <div class="profile-form-input">
                <InputLabel for="country" value="Country"/>

                <v-select
                    id="country"
                    v-model="form.country_id"
                    :items="props.countries"
                    item-value="id"
                    item-title="name"
                    required
                />
            </div>

            <div class="profile-form-input">
                <InputLabel for="email" value="Email"/>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />

                <InputError class="mt-2" :message="form.errors.email"/>
            </div>

            <div class="profile-form-input">
                <InputLabel for="phoneNumber" value="Phone number"/>

                <v-text-field
                    id="phoneNumber"
                    type="text"
                    v-model="form.phone"
                    v-mask="'+00 (000) 00 00 000'"
                    placeholder="+00 (000) 00 00 000"
                    :rules="rules.phone"
                />
            </div>

            <div class="profile-form-input">
                <InputLabel for="birthdate" value="Birth Date"/>

                <v-text-field
                    id="birthdate"
                    type="date"
                    v-model="form.birthdate"
                    placeholder="dd-mm-yyyy"
                    max="2018-12-31"
                />
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition enter-from-class="opacity-0" leave-to-class="opacity-0" class="transition ease-in-out">
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
