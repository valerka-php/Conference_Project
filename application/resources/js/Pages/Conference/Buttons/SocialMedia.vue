<template>
    <div>
        <ShareNetwork
            class="share-link bi bi-facebook mr-5"
            network="facebook"
            :url="this.url"
            :title="this.text"
            description="Descriptions here"
            quote="The hot reload is so fast it\'s near instant. - Evan You"
            hashtags="vue,bwt,ukraine"
        />

        <ShareNetwork
            class="share-link bi bi-telegram mr-5"
            network="telegram"
            :url="this.url"
            :title="this.text"
            description="Descriptions here"
            quote="The hot reload is so fast it\'s near instant. - Evan You"
            hashtags="vue,bwt,ukraine"
        />

        <ShareNetwork
            class="share-link bi bi-twitter mr-5"
            network="twitter"
            :url="this.url"
            :title="this.text"
            quote="The hot reload is so fast it\'s near instant. - Evan You"
            hashtags="vue,bwt,ukraine"
        />

    </div>
</template>

<script>
import {ShareNetwork} from "vue-social-sharing/src/vue-social-sharing";

export default {
    name: "ShareLinks",

    props: {
        url: String,
        text: String,
    },

    components: {
        ShareNetwork
    }
}
</script>

<style scoped>

</style>
