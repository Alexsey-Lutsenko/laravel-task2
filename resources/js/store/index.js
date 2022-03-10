import Vuex from "vuex";
import login from "./modules/login.module";
import image from "./modules/image.module";
import client from "./modules/client.module";
import title from "./modules/title.module";

export default new Vuex.Store({
    state() {
        return {
            loader: false,
            message: {
                text: "",
                type: "",
            },
        };
    },
    getters: {
        getLoader(state) {
            return state.loader;
        },
        getMessage(state) {
            return state.message;
        },
    },
    mutations: {
        addLoader(state) {
            state.loader = true;
        },
        removeLoader(state) {
            state.loader = false;
        },
        setMessage(state, payload) {
            state.message = payload;
        },
    },
    modules: { login, image, client, title },
});
