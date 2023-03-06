<template>
    <Head title="Register"/>

    <div class="register-form">
        <v-form
            ref="form"
            v-model="valid"
            lazy-validation
            style="width: 360px;"
            class="mt-5"
        >
            <div>
                <v-text-field
                    v-model="form.firstName"
                    :counter="25"
                    :rules="nameRules"
                    label="First Name"
                    required
                ></v-text-field>
                <div class="mb-5" v-if="errors.firstName"> {{ errors.firstName }}</div>
            </div>

            <div>
                <v-text-field
                    v-model="form.lastName"
                    :counter="25"
                    :rules="nameRules"
                    label="Last Name"
                    required
                ></v-text-field>
                <div class="mb-5" v-if="errors.lastName"> {{ errors.lastName }}</div>

            </div>

            <div>
                <v-text-field
                    v-model="form.email"
                    :rules="emailRules"
                    label="E-mail"
                    required
                ></v-text-field>
                <div class="error-form" v-if="errors.email"> {{ errors.email }}</div>
            </div>

            <div>
                <v-text-field
                    v-model="form.password"
                    label="Password"
                    name="password"
                    type="password"
                    :rules="passwordRules"
                />
            </div>


            <div>
                <v-text-field
                    v-model="form.confirmPassword"
                    label="Confirm Password"
                    name="confirmPassword"
                    type="password"
                    :rules="[!!form.confirmPassword || 'type confirm password', form.password === form.confirmPassword || 'The password confirmation does not match.']"
                />
            </div>

            <div>
                <v-select
                    v-model="form.roleId"
                    :items="this.roles"
                    item-value="id"
                    item-title="role"
                ></v-select>
            </div>

            <div>
                <v-select
                    v-model="form.countryId"
                    :items="countries"
                    item-value="id"
                    item-title="name"
                    label="Country"
                    required
                ></v-select>
            </div>

            <div>
                <v-text-field
                    type="date"
                    v-model="form.birthDate"
                    placeholder="dd-mm-yyyy"
                    max="2018-12-31"
                />
            </div>

            <div>
                <v-text-field
                    type="text"
                    v-model="form.phone"
                    v-mask="'+00 (000) 00 00 000'"
                    placeholder="+00 (000) 00 00 000"
                    :rules="phoneRules"
                    label="Phone Number"
                />
            </div>

            <div class="register-form-footer">
                <Link
                    :href="route('home')"

                    class="ml-4 btn btn-secondary btn-back v-btn v-btn--elevated v-theme--light v-btn--density-default v-btn--size-default v-btn--variant-elevated"
                >
                    back
                </Link>

                <v-btn
                    @click="submit"
                    :disabled="!valid"
                    color="success"
                    class="mr-4"
                >
                    submit
                </v-btn>
            </div>
        </v-form>
    </div>
</template>

<script>
import {Link, Head} from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
        Head,
    },

    props: {
        countries: Array,
        errors: Object,
    },

    data: () => ({
        valid: true,
        phoneRules: [
            (value) => (value && value.length >= 10) || 'minimum 10 characters',
        ],
        passwordRules: [
            (value) => !!value || 'Please type password.',
            (value) => (value && value.length >= 6) || 'minimum 6 characters',
        ],
        nameRules: [
            value => !!value || 'Name is required',
            value => (value && value.length <= 25) || 'Name must be less than 25 characters',
            value => (value && value.length >= 2) || 'Name must be more than 2 characters',
        ],
        emailRules: [
            value => !!value || 'E-mail is required',
            value => /.+@.+\..+/.test(value) || 'E-mail must be valid',
        ],
        roles: [
            {
                role: 'Announcer',
                id: 2,
            },
            {
                role: 'Listener',
                id: 1,
            },

        ],
        form: {
            firstName: '',
            lastName: '',
            password: '',
            confirmPassword: '',
            email: '',
            countryId: 227,
            roleId: 1,
            birthDate: '',
            phone: '',
        }
    }),

    methods: {
        validate() {
            this.$refs.form.validate()
        },
        submit() {
            this.$inertia.post('/register', this.form)
        }
    },
}
</script>
