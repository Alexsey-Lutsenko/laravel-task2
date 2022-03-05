import axios from "axios";
import store from "../index";
import errorHandler from "../../utils/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            admin: {},
            login: localStorage.getItem("login"),
            errors: [],
            errorCount: 0,
        };
    },
    getters: {
        getAdmin(state) {
            return state.admin;
        },
        getLogin(state) {
            return state.login;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
    mutations: {
        setLogin(state, request) {
            state.login = request;
            localStorage.setItem("login", true);
        },
        addAdmin(state, request) {
            state.admin = request;
        },
        addErrors(state, requests) {
            if (requests.errors) {
                state.errorCount = 1;
            }
            state.errors = requests.errors;
            if (requests.message) {
                console.error("ERROR: ", requests.message);
            }
        },
        remuveError(state) {
            state.errorCount = 0;
            state.errors = [];
        },
    },
    actions: {
        async store({ commit }) {
            try {
                store.commit("addLoader", { root: true });
                const { data } = await axios.get("api/users/admin");
                commit("addAdmin", data.data);
            } catch (e) {
                commit("addErrors", errorHandler(e));
            } finally {
                store.commit("removeLoader", { root: true });
            }
        },

        async login({ commit }, payload) {
            try {
                const { data } = await axios.get("api/users/login?email=" + payload.email + "&password=" + payload.password);
                commit("setLogin", data.data.login);
                store.commit("setMessage", { text: data.data.message, type: "danger" }, { root: true });
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
};
