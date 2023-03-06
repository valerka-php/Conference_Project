<template>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="container" v-if="$page.props.auth.user">
            <v-btn
                :href="route('home')"
                class="btn btn-outline-secondary navbar-brand"
            > Conferences
            </v-btn>

            <v-badge
                v-if="this.$store.getters.getFavorite.length >= 1"
                :content="this.$store.getters.getFavorite.length > 99 ? '99+' : this.$store.getters.getFavorite.length "
                style="margin-right: 25px"
            >
                <Link
                    class="bi bi-star-fill favorite-link"
                    style="font-size: 28px"
                    :href="route('favorites.index',{user:$page.props.auth.user.id})"
                />
            </v-badge>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarContent"
                aria-controls="navbarContent"
                aria-expanded="false"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="navbar-collapse collapse" id="navbarContent">
                <div class="navbar-content-custom show">
                    <ul class="navbar-nav">
                        <li class="nav-item layout-item-list" v-if="$page.props.auth.isAdmin">
                            <show-categories-button />
                        </li>
                        <li class="nav-item layout-item-list" v-if="$page.props.auth.canCreate">
                            <v-btn
                                :href="route('conferences.create')"
                                class="btn btn-outline-secondary"
                                @click="this.$store.commit('clearCoordinates')"
                            >
                                Create Conference
                            </v-btn>
                        </li>
                        <li class="nav-item layout-item-list">
                            <v-btn
                                :href="route('profile.edit')"
                                class="btn btn-outline-secondary btn-login nav-link"
                            >
                                Profile
                            </v-btn>
                        </li>
                        <li class="nav-item layout-item-list" style="height: 46px;">
                            <LogOutButton class="nav-link"></LogOutButton>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
        <div class="container" v-else>

            <v-btn :href="route('login')" class="btn btn-outline-secondary btn-login navbar-brand">Log in</v-btn>

            <v-btn
                v-if="canRegister"
                :href="route('register')"
                class="btn btn-outline-secondary "
            >
                Register
            </v-btn>
        </div>
    </nav>
    <div
        v-if="$page.props.flash.message"
        class="flash-message-home"
    >
        {{ $page.props.flash.message }}
    </div>
</template>

<script>
import LogOutButton from "@/Components/Buttons/LogOutButton.vue";
import {Link} from "@inertiajs/inertia-vue3";
import ShowCategoriesButton from "@/Components/Buttons/Admin/ShowCategoriesButton.vue";

export default {
    name: "Burger",

    components: {
        LogOutButton,
        Link,
        ShowCategoriesButton
    },

    props: {
        canRegister: Boolean,
    },

    data() {
        return {
            hasFavoriteReport: false,
        }
    },

    mounted() {
        this.$store.commit("setFavorite", this.$page.props.auth.favoriteReport);
    },
}
</script>

<style scoped>

</style>
