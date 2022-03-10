<template>
    <div class="container my-3">
        <nav class="navbar navbar-expand-lg navbar-light border-bottom">
            <div class="d-flex logo">
                <i id="icon-camera" class="fa-solid fa-camera-retro"></i>
                Photo
            </div>
            <div class="d-flex justify-content-center menu-position">
                <ul class="navbar-nav title-layout">
                    <li class="nav-item">
                        <router-link class="nav-link py-0" :to="'/'">Главная</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link py-0" :to="'/admin'">Админ</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link py-0" :to="'/login'" @click="logout">Выйти</router-link>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    <div class="w-100">
        <router-view></router-view>
    </div>
</template>

<script>
export default {
    setup() {
        return {
            logout: () => {
                localStorage.removeItem("login");
            },
        };
    },
};
</script>

<style></style>
