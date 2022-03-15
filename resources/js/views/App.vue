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
    width: 65%;
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
.dz-filename {
    max-width: 265px;
    overflow: hidden;
    text-overflow: ellipsis;
}
img {
    cursor: pointer;
}
.v-select {
    width: 200px;
}
.vs__dropdown-toggle {
    border: none;
    border-bottom: 1px solid var(--app-color-grey);
    border-top-left-radius: 0.25rem;
    border-top-right-radius: 0.25rem;
    padding: 0 0 4px;
}
.vs__search,
.vs__search:focus {
    color: #000;
    font-size: 15px;
    margin-top: 8px;
}
.vs__selected {
    max-width: 135px;
    overflow-x: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    display: block;
}
</style>
