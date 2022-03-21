<template>
    <div class="d-flex justify-content-center mt-4">
        <h1>Создание заявки</h1>
    </div>

    <div class="d-flex justify-content-center m2-4" v-if="createMessage">
        <h6 class="text-success">Ваша заявку успешно создана</h6>
    </div>

    <div class="d-flex justify-content-center mt-4" v-if="loader">
        <app-loader class="my-5" v-if="loader"></app-loader>
    </div>

    <div class="d-flex justify-content-center mt-3" v-if="!loader">
        <div class="d-flex order-form">
            <div class="input-block">
                <app-input v-model.trim="clientModel.fio" type="text" placeholder="ФИО*"></app-input>
                <small class="text-danger error-text" v-if="errors.fio">{{ errors.fio }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.number="clientModel.phone_number" type="text" placeholder="Телефон*"></app-input>
                <small class="text-danger error-text" v-if="errors.phone_number">{{ errors.phone_number }}</small>
            </div>
            <div class="input-block">
                <datepicker
                    v-model="clientModel.date_time"
                    placeholder="Дата и время*"
                    :format="format"
                    :previewFormat="format"
                    locale="ru"
                    selectText="Ок"
                    cancelText="Отмена"
                >
                </datepicker>
                <small class="text-danger error-text" v-if="errors.date_time">{{ errors.date_time }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="clientModel.location" type="text" placeholder="Локация*"></app-input>
                <small class="text-danger error-text" v-if="errors.location">{{ errors.location }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="clientModel.mail" type="text" placeholder="Почта*"></app-input>
                <small class="text-danger error-text" v-if="errors.mail">{{ errors.mail }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="clientModel.title" type="text" placeholder="Тема"></app-input>
                <small class="text-danger error-text" v-if="errors.title">{{ errors.title }}</small>
            </div>
            <div class="input-block">
                <div class="d-flex justify-content-center" v-if="loader_captcha">
                    <app-loader></app-loader>
                </div>
                <div class="d-flex justify-content-center captcha" v-if="!loader_captcha">
                    <span>
                        <img :src="captchaPath.captcha_path" />
                    </span>
                    <button type="button" class="btn btn-light mx-2" @click="captcha_reload"><i class="fa-solid fa-rotate"></i></button>
                </div>
                <div class="form-group mt-1 mb-3" v-if="!loader_captcha">
                    <app-input id="captcha" type="text" v-model="clientModel.captcha" placeholder="Введите текст с картинки" name="captcha" />
                    <small class="text-danger error-text" v-if="errors.captcha">{{ errors.captcha }}</small>
                </div>
            </div>

            <div class="d-flex justify-content-center mt-3 m-auto">
                <app-button-success class="button-style" @click.prevent="send"></app-button-success>
                <app-button-cancel class="button-style mx-2" @click.prevent="cancel"></app-button-cancel>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, computed, ref, watch } from "vue";
import { useStore } from "vuex";
import dateFormat, { masks } from "dateformat";

export default {
    setup() {
        const store = useStore();
        const clientModel = ref({});
        const loader = ref(false);
        const loader_captcha = ref(false);
        const createMessage = ref(false);

        const format = (date) => {
            return dateFormat(date, "dd.mm.yyyy HH:MM");
        };

        const formatInp = (date) => {
            return dateFormat(date, "yyyy-mm-dd HH:MM");
        };

        const errors = computed(() => store.getters["client/getErrors"]);
        const captchaPath = computed(() => store.getters["client/getCaptchaPatch"]);
        const errorCount = computed(() => store.getters["client/getErrorCount"]);

        const captcha_reload = async () => {
            loader_captcha.value = true;
            await store.dispatch("client/reloadCaptcha");
            loader_captcha.value = false;
        };

        onMounted(async () => {
            await captcha_reload();
        });

        return {
            clientModel,
            loader,
            loader_captcha,
            errors,
            errorCount,
            captchaPath,
            createMessage,
            format,
            formatInp,
            captcha_reload,
            send: async () => {
                loader.value = true;
                await store.dispatch("client/checkCaptcha", { captcha: clientModel.value.captcha });
                delete clientModel.value.captcha;
                await captcha_reload();

                if (!errors.value.captcha) {
                    if(clientModel.value.date_time) {
                        clientModel.value.date_time = formatInp(clientModel.value.date_time)
                    }
                    await store.dispatch("client/store", clientModel.value);


                    if (errorCount.value == 0) {
                        createMessage.value = true
                        setTimeout(() => {
                            createMessage.value = false
                        }, 2000)
                        clientModel.value = {};
                    }
                }
                loader.value = false;
            },
            cancel: () => {
                clientModel.value = {};
            },
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
    width: 100%;
    margin-top: 15px;
}
.button-style {
    height: min-content;
}
.order-form {
    width: 400px;
    flex-wrap: wrap;
}
</style>
