<template>
    <div class="container mt-3 mb-1">
        <nav class="navbar navbar-expand-lg navbar-light border-bottom">
            <div class="d-flex logo" @click="goMainPage">
                <i id="icon-camera" class="fa-solid fa-camera-retro"></i>
                Photo
            </div>
            <button class="btn btn-order-photo">
                <router-link class="py-0 link-order-photo" :to="'/order-photo'">Сделать заказ</router-link>
            </button>
            <div class="d-flex justify-content-center menu-position">
                <ul class="navbar-nav title-layout">
                    <li class="nav-item">
                        <router-link class="nav-link py-0" :to="'/'">Главная</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link py-0" :to="'/gallery'">Галерея</router-link>
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
import {useRouter} from "vue-router"

export default {
    setup() {
        const router = useRouter();

        return {
            logout: () => {
                localStorage.removeItem("login");
            },
            goMainPage: () => {
                if(localStorage.getItem('login'))
                router.push('/')
            }
        };
    },
};
</script>

<style lang="scss" scoped>
$red: #e1332d;

.btn-order-photo {
    width: 150px;
    margin-left: 15px;
    border: 1px solid #dee2e6;
    transition: all 150ms linear;
    &:hover {
        background: darken(#dad8d8, 1.5%);
        transition: all 250ms linear;
    }
    &:focus {
        box-shadow: none;
    }
}

.link-order-photo {
    text-decoration: none;
    color: #555555;
}
</style>
