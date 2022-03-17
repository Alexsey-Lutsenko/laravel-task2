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
                <datepicker
                    v-model="clientModel.date_time"
                    placeholder="Дата и время"
                    :format="format"
                    :previewFormat="format"
                    locale="ru"
                    selectText="Ок"
                    cancelText="Отмена"
                    @closed="formatInp(clientModel.date_time)"
                >
                </datepicker>
                <small class="text-danger error-text" v-if="errors.date_time">{{ errors.date_time }}</small>
            </div>
            <div class="input-block mx-2">
                <app-input v-model.trim="clientModel.location" type="text" placeholder="Локация"></app-input>
                <small class="text-danger error-text" v-if="errors.location">{{ errors.location }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="clientModel.mail" type="text" placeholder="Почта"></app-input>
                <small class="text-danger error-text" v-if="errors.mail">{{ errors.mail }}</small>
            </div>
            <div class="input-block mx-2">
                <v-select :options="titleArr" v-model="clientModel.title" placeholder="Тема" taggable></v-select>
                <small class="text-danger error-text" v-if="errors.title">{{ errors.title }}</small>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <app-button-success class="button-style" @click.prevent="send"></app-button-success>
        </div>
        <div class="d-flex justify-content-center mx-2">
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
                    <th scope="col">Дата и время</th>
                    <th scope="col">Локация</th>
                    <th scope="col">Почта</th>
                    <th scope="col">Тема</th>
                    <th scope="col">Статус</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client of clients" :key="client.id">
                    <td>{{ client.fio }}</td>
                    <td>{{ client.phone_number }}</td>
                    <td>{{ format(client.date_time) }}</td>
                    <td>{{ client.location }}</td>
                    <td>{{ client.mail }}</td>
                    <td>{{ client.title }}</td>
                    <td>
                        <select :class="[client.status_id == 2 ? 'status-select-ready' : 'status-select-process', 'p-0 form-select']">
                            <option
                                v-for="status of statuses"
                                :key="status.id"
                                :value="status.id"
                                :selected="client.status_id == status.id"
                                @click="editStatus(client, status.id)"
                            >
                                {{ status.status }}
                            </option>
                        </select>
                    </td>
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
import vSelect from "vue-select";
import dateFormat, { masks } from "dateformat";

export default {
    setup() {
        const store = useStore();
        const clientModel = ref({});
        const typeFunction = ref(1);
        const titleArr = ref([]);

        const format = (date) => {
            return dateFormat(date, "dd.mm.yyyy HH:MM");
        };

        const formatInp = (date) => {
            clientModel.value.date_time = dateFormat(date, "yyyy-mm-dd HH:MM");
        };

        const clients = computed(() => store.getters["client/getClients"]);
        const titles = computed(() => store.getters["title/getTitles"]);
        const statuses = computed(() => store.getters["status/getStatuses"]);
        const errors = computed(() => store.getters["client/getErrors"]);
        const errorCount = computed(() => store.getters["client/getErrorCount"]);
        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(async () => {
            await store.dispatch("client/index");
            await store.dispatch("title/index");
            await store.dispatch("status/index");

            titles.value.forEach((title) => {
                titleArr.value.push(title.title);
            });
        });

        const editStatus = async (client, status_id) => {
            console.log(client.status_id, status_id);
            if (client.status_id !== status_id) {
                await store.dispatch("client/update", { id: client.id, status_id: status_id });
            }
        };

        const create = async () => {
            await store.dispatch("client/store", clientModel.value);
            if (errorCount.value == 0) {
                clientModel.value = {};
            }
        };

        const update = (id) => {
            window.scrollTo(0, 0);
            clients.value.forEach((client) => {
                if (client.id == id) {
                    clientModel.value = Object.assign({}, client);
                    clientModel.value.title_id = null;
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
            titles,
            statuses,
            titleArr,
            format,
            formatInp,
            editStatus,
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
            cancel: () => {
                clientModel.value = {};
                typeFunction.value = 1;
            },
        };
    },
    components: {
        vSelect,
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
.form-select {
    cursor: pointer;
    text-align: center;
}
.status-select-ready {
    border: 1px solid #69da69;
    background: #9dd89d;
    &:focus {
        box-shadow: none;
    }
}
.status-select-process {
    border: 1px solid #698dda;
    background: #9db9d8;
    &:focus {
        box-shadow: none;
    }
}
</style>
