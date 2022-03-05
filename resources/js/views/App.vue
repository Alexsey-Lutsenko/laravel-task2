<template>
    <component :is="layout + '-layout'" v-if="layout"></component>
</template>

<script>
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import AuthLayout from "./layout/AuthLayout.vue";
import MainLayout from "./layout/MainLayout.vue";

export default {
    setup() {
        const store = useStore();
        const route = useRoute();

        return {
            layout: computed(() => route.meta.layout),
        };
    },
    components: {
        AuthLayout,
        MainLayout,
    },
};
</script>

<style>
.title-layout {
    font-size: 16px;
}
.menu-position {
    width: 89%;
}
#icon-camera {
    font-size: 20px;
    margin-right: 5px;
}
.logo {
    cursor: pointer;
}
</style>
