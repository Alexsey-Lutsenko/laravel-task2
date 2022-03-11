<template>
    <div class="d-flex justify-content-center">
        <h1>Темы</h1>
    </div>

    <div class="d-flex justify-content-center" v-if="message">
        <h6 class="text-danger mt-1">{{ message }}</h6>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <div class="d-flex">
            <div class="input-block">
                <app-input v-model.trim="titleModel.title" type="text" placeholder="Тема"></app-input>
                <small class="text-danger error-text" v-if="errors.title">{{ errors.title }}</small>
            </div>
            <div class="input-block mx-2">
                <app-input v-model.trim="titleModel.description" type="text" placeholder="Описание"></app-input>
                <small class="text-danger error-text" v-if="errors.description">{{ errors.description }}</small>
            </div>
        </div>
        <div class="d-flex justify-content-center mx-2">
            <app-button-success class="button-style" @click.prevent="send"></app-button-success>
        </div>
        <div class="d-flex justify-content-center">
            <app-button-cancel class="button-style" @click.prevent="cancel"></app-button-cancel>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <app-loader class="mt-3" v-if="loader"></app-loader>
        <table class="table table-hover w-50" v-if="!loader">
            <thead>
                <tr>
                    <th scope="col">Тема</th>
                    <th scope="col">Описание</th>
                    <th scope="col">Кол-во клиентов</th>
                    <th scope="col">Кол-во фото</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="title of titles" :key="title.id">
                    <td>{{ title.title }}</td>
                    <td>{{ title.description }}</td>
                    <td>{{ title.cnt_clients }}</td>
                    <td>{{ title.cnt_images }}</td>
                    <td>
                        <i class="fa-solid fa-user-pen add-icon-style" @click.prevent="update(title.id)"></i>
                    </td>
                    <td>
                        <i class="fa-regular fa-circle-xmark add-icon-style" @click.prevent="destroy(title.id)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import { onMounted, computed, ref, watch } from "vue";
import { useStore } from "vuex";

export default {
    setup() {
        const store = useStore();
        const titleModel = ref({});
        const typeFunction = ref(1);

        const titles = computed(() => store.getters["title/getTitles"]);
        const message = computed(() => store.getters["title/getMessage"]);
        const errors = computed(() => store.getters["title/getErrors"]);
        const errorCount = computed(() => store.getters["title/getErrorCount"]);
        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(async () => {
            await store.dispatch("title/index");
        });

        const create = async () => {
            await store.dispatch("title/store", titleModel.value);
            if (errorCount.value == 0) {
                titleModel.value = {};
            }
        };

        const update = (id) => {
            window.scrollTo(0, 0);
            titles.value.forEach((element) => {
                if (element.id == id) {
                    titleModel.value = Object.assign({}, element);
                }
            });
            typeFunction.value = 2;
        };

        return {
            titles,
            loader,
            titleModel,
            errors,
            update,
            message,
            send: async () => {
                if (typeFunction.value == 1) {
                    await create();
                } else if (typeFunction.value == 2) {
                    await store.dispatch("title/update", titleModel.value);
                    if (errorCount.value == 0) {
                        titleModel.value = {};
                    }
                }
            },
            destroy: async (id) => {
                await store.dispatch("title/destroy", id);
            },
            cancel: () => (titleModel.value = {}),
        };
    },
};
</script>

<style lang="scss" scoped>
.add-icon-style {
    font-size: 18px;
    cursor: pointer;
    color: #555555;
    &:hover {
        color: #000000;
    }
}
.error-text {
    font-size: 10px;
}
.input-block {
    max-width: 200px;
}
.button-style {
    height: min-content;
}
</style>
