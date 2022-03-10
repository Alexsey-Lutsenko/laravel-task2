<template>
    <div class="container mb-3">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="d-flex justify-content-center menu-position">
                <ul class="navbar-nav title-layout">
                    <li :class="[{ active: component == 'client' }, 'nav-item']" @click="getComponent('client')">Клиенты</li>
                    <li :class="[{ active: component == 'title' }, 'nav-item mx-3']" @click="getComponent('title')">Темы</li>
                    <li :class="[{ active: component == 'image' }, 'nav-item']" @click="getComponent('image')">Фото</li>
                </ul>
            </div>
        </nav>
    </div>
    <component :is="component + '-admin-component'" />
</template>

<script>
import { ref } from "vue";
import ClientAdminComponent from "../../components/adminComponent/ClientAdminComponent.vue";
import ImageAdminComponent from "../../components/adminComponent/ImageAdminComponent.vue";
import TitleAdminComponent from "../../components/adminComponent/TitleAdminComponent.vue";

export default {
    setup() {
        const component = localStorage.getItem("component") ? ref(localStorage.getItem("component")) : ref("image");

        return {
            component,
            getComponent: (name) => {
                component.value = name;
                localStorage.setItem("component", component.value);
            },
        };
    },
    components: {
        ClientAdminComponent,
        ImageAdminComponent,
        TitleAdminComponent,
    },
};
</script>

<style scoped>
.menu-position {
    width: 100%;
}
.active {
    color: rgba(0, 0, 0, 0.9);
}
.nav-item {
    cursor: pointer;
}
</style>
