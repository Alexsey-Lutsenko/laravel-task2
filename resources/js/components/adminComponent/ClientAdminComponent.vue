<template>
    <div class="d-flex justify-content-center">
        <h1>Клиенты</h1>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <div class="d-flex">
            <div class="input-block">
                <app-input v-model.trim="clientModel.fio" type="text" placeholder="ФИО"></app-input>
                <small class="text-danger error-text" v-if="errors.fio">{{ errors.fio }}</small>
            </div>
            <div class="input-block mx-2">
                <app-input v-model.number="clientModel.phone_number" type="text" placeholder="Телефон"></app-input>
                <small class="text-danger error-text" v-if="errors.phone_number">{{ errors.phone_number }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="clientModel.location" type="text" placeholder="Локация"></app-input>
                <small class="text-danger error-text" v-if="errors.location">{{ errors.location }}</small>
            </div>
            <div class="input-block mx-2">
                <app-input v-model.trim="clientModel.mail" type="text" placeholder="Почта"></app-input>
                <small class="text-danger error-text" v-if="errors.mail">{{ errors.mail }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="clientModel.title" type="text" placeholder="Тема"></app-input>
                <small class="text-danger error-text" v-if="errors.title">{{ errors.title }}</small>
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
        <table class="table table-hover w-75" v-if="!loader">
            <thead>
                <tr>
                    <th scope="col">ФИО</th>
                    <th scope="col">Телефон</th>
                    <th scope="col">Локация</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Тема</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client of clients" :key="client.id">
                    <td>{{ client.fio }}</td>
                    <td>{{ client.phone_number }}</td>
                    <td>{{ client.location }}</td>
                    <td>{{ client.mail }}</td>
                    <td>{{ client.title }}</td>
                    <td>
                        <i class="fa-solid fa-user-pen add-icon-style" @click.prevent="update(client.id)"></i>
                    </td>
                    <td>
                        <i class="fa-regular fa-circle-xmark add-icon-style" @click.prevent="destroy(client.id)"></i>
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
        const clientModel = ref({});
        const typeFunction = ref(1);

        const clients = computed(() => store.getters["client/getClients"]);
        const errors = computed(() => store.getters["client/getErrors"]);
        const errorCount = computed(() => store.getters["client/getErrorCount"]);
        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(async () => {
            await store.dispatch("client/index");
        });

        const create = async () => {
            await store.dispatch("client/store", clientModel.value);
            if (errorCount.value == 0) {
                clientModel.value = {};
            }
        };

        const update = async (id) => {
            window.scrollTo(0, 0);
            clients.value.forEach((element) => {
                if (element.id == id) {
                    clientModel.value = Object.assign({}, element);
                }
            });
            typeFunction.value = 2;
        };

        return {
            clients,
            loader,
            clientModel,
            errors,
            update,
            send: async () => {
                if (typeFunction.value == 1) {
                    await create();
                } else if (typeFunction.value == 2) {
                    await store.dispatch("client/update", clientModel.value);
                    if (errorCount.value == 0) {
                        clientModel.value = {};
                        typeFunction.value = 1;
                    }
                }
            },
            destroy: async (id) => {
                await store.dispatch("client/destroy", id);
            },
            cancel: () => (clientModel.value = {}),
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
