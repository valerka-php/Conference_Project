<template>
    <Head title="Subscription"/>

    <HomeLayout :can-register="canRegister"/>

    <v-carousel
        height="700"
        hide-delimiter-background
        show-arrows="hover"
    >
        <v-carousel-item
            v-for="(plan, i) in plans"
            :key="i"
        >
            <v-sheet
                height="100%"
                class="carousel-plans"
            >
                <div class="col-lg-4 mb-15">
                    <div class="bg-white p-5 rounded-lg shadow plan-card">
                        <h1 class="h6 text-uppercase font-weight-bold mb-4">{{ plan.name }}</h1>
                        <h2 class="h1 font-weight-bold">${{ plan.price }}<span
                            class="text-small font-weight-normal ml-2">/ month</span></h2>

                        <ul class="list-unstyled my-5 text-small text-left font-weight-normal">
                            <li class="mb-3">
                                <i class="fa fa-check mr-2 text-primary"></i> Lorem ipsum dolor sit amet
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-check mr-2 text-primary"></i> Sed ut perspiciatis
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-check mr-2 text-primary"></i> At vero eos et accusamus
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-check mr-2 text-primary"></i> Nam libero tempore
                            </li>
                            <li class="mb-3">
                                <i class="fa fa-check mr-2 text-primary"></i> Sed ut perspiciatis
                            </li>
                            <li class="mb-3 text-muted">
                                <i class="fa fa-times mr-2"></i>
                                <del>Sed ut perspiciatis</del>
                            </li>
                        </ul>
                        <v-btn
                            v-if="plan.name === 'free'"
                            disabled
                        >
                            Active
                        </v-btn>

                        <Unsubscribe
                            v-else-if="subscribed(plan.name)"
                            :plan-name="plan.name"
                        />

                        <v-btn
                            v-else
                            :href="route('subscription.create', {plan: plan.id})"
                            class="btn btn-primary btn-block shadow rounded-pill"
                        >Subscribe
                        </v-btn>
                    </div>
                </div>
            </v-sheet>
        </v-carousel-item>
    </v-carousel>
</template>

<script>
import Unsubscribe from "@/Pages/Plan/Buttons/Unsubscribe.vue";
import {Head, Link} from '@inertiajs/inertia-vue3';
import HomeLayout from "@/Layouts/HomeLayout.vue";

export default {
    name: "Show",
    components: {
        Unsubscribe,
        HomeLayout,
        Head
    },

    props: {
        plans: Object,
        subscriptions: Object,
        message: String,
    },

    data() {
        return {
            subscriptionId: '',
        }
    },

    methods: {
        subscribed(plan) {
            let subscription = this.getSubscription(plan);

            if (subscription && subscription.stripe_status === 'active') {
                return true;
            }
            return false;
        },

        getSubscription(plan) {
            return this.subscriptions.find(({name}) => name === plan)
        }
    },

    mounted() {
        if (this.message) {
            this.$page.props.flash.message = this.message
        }
    }
}
</script>

<style scoped>

</style>
