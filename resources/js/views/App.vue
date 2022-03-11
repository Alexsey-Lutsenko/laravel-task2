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

<style lang="scss">
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
.page-item.active a.page-link {
    color: #fff !important;
    background-color: #555 !important;
    border-color: #555 !important;
}
.page-link {
    color: #555 !important;
}
.page-link:focus {
    box-shadow: none !important;
}
.dz-image img,
.dz-success-mark,
.dz-error-mark,
.dz-size {
    display: none;
}
.dz-filename {
    margin-top: 15px;
}
.dz-remove {
    color: #fff !important;
    text-decoration: none;
    border: 1px solid #fff;
    border-radius: 3px;
    padding: 3px;
    &:hover {
        font-weight: bold;
    }
}
.dz-error-message {
    color: red !important;
}
img {
    cursor: pointer;
}
</style>
