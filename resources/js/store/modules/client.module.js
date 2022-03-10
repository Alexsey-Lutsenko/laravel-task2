import axios from "axios";
import store from "../index";
import errorHandler from "../../utils/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            clients: [],
            errors: [],
            errorCount: 0,
        };
    },
    getters: {
        getClients(state) {
            return state.clients;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
    },
    mutations: {
        addClients(state, payload) {
            state.clients = payload;
        },
        addErrors(state, requests) {
            if (requests.errors) {
                state.errorCount = 1;
            }
            state.errors = requests.errors;
        },
        remuveError(state) {
            state.errorCount = 0;
            state.errors = [];
        },
    },
    actions: {
        async index({ commit }) {
            try {
                store.commit("addLoader", { root: true });
                const { data } = await axios.get("api/clients");
                commit("addClients", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            } finally {
                store.commit("removeLoader", { root: true });
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/clients", payload);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit, dispatch }, payload) {
            try {
                await axios.patch(`api/clients/${payload.id}`, payload);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit, dispatch }, id) {
            try {
                await axios.delete(`api/clients/${id}`);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
};
