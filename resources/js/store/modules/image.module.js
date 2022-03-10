import axios from "axios";
import store from "../index";
import errorHandler from "../../utils/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            images: [],
            errors: [],
            errorCount: 0,
            message: "",
        };
    },
    getters: {
        getImages(state) {
            return state.images;
        },
        getErrors(state) {
            return state.errors;
        },
        getErrorCount(state) {
            return state.errorCount;
        },
        getMessage(state) {
            return state.message;
        },
    },
    mutations: {
        addImages(state, payload) {
            state.images = payload;
        },
        addMessage(state, payload) {
            state.message = payload;
            setTimeout(() => {
                state.message = "";
            }, 2000);
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
        async index({ commit }, page = 1) {
            try {
                store.commit("addLoader", { root: true });
                const { data } = await axios.get("api/images?page=" + page);
                commit("addImages", data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            } finally {
                store.commit("removeLoader", { root: true });
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/images", payload);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit, dispatch }, payload) {
            try {
                await axios.post(`api/images/${payload.id}`, payload.formData);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit, dispatch }, id) {
            try {
                await axios.delete(`api/images/${id}`);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
};
