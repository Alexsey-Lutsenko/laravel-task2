<template>
    <div class="d-flex justify-content-center mt-5 mb-3">
        <h1 class="fs-3">Вход</h1>
    </div>

    <div class="d-flex justify-content-center">
        <h6 class="text-danger">{{ message.text }}</h6>
    </div>

    <div class="d-flex justify-content-center">
        <form class="login-form">
            <app-input type="text" placeholder="login" v-model="email"></app-input>
            <app-input type="password" placeholder="password" class="my-5" v-model="password"></app-input>

            <div class="d-flex justify-content-center">
                <app-button-success @click.prevent="login">Войти</app-button-success>
            </div>
        </form>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <span class="mx-3">Временный вход</span>
    </div>
    <div class="d-flex justify-content-center mt-3">
        <app-loader v-if="loader"></app-loader>
        <div v-if="!loader">
            <span class="mx-1">{{ admin.email }}</span>
            <span class="mx-1">{{ admin.password }}</span>
        </div>
    </div>
    <!-- <app-toast :text="message.text" :type="message.type"></app-toast> -->
</template>

<script>
import { computed, onMounted, watch, ref } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default {
    setup() {
        const store = useStore();
        const router = useRouter();
        const email = ref(null);
        const password = ref(null);

        const admin = computed(() => store.getters["login/getAdmin"]);
        const login = computed(() => store.getters["login/getLogin"]);
        const message = computed(() => store.getters["getMessage"]);

        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(() => store.dispatch("login/store"));

        return {
            admin,
            loader,
            email,
            password,
            message,
            login: async () => {
                await store.dispatch("login/login", { email: email.value, password: password.value });
                if (login.value) {
                    router.push("/admin");
                }
            },
        };
    },
};
</script>

<style scoped>
.login-form {
    max-width: 300px;
}
</style>
