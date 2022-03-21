import axios from "axios";
import store from "../index";
import errorHandler from "../../utils/errorHandler";

export default {
    namespaced: true,
    state() {
        return {
            titles: [],
            title: {},
            errors: [],
            errorCount: 0,
            message: "",
        };
    },
    getters: {
        getTitles(state) {
            return state.titles;
        },
        getTitle(state) {
            return state.title;
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
        addTitles(state, payload) {
            state.titles = payload;
        },
        addTitle(state, payload) {
            state.title = payload;
        },
        addMessage(state, payload) {
            state.message = payload;
            setTimeout(() => {
                state.message = "";
            }, 2000);
        },
        addErrors(state, requests) {
            if(requests.message) {
                console.error('Error: ' + requests.message)
            }

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
                const { data } = await axios.get("api/titles");
                commit("addTitles", data.data);
                commit("remuveError");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            } finally {
                store.commit("removeLoader", { root: true });
            }
        },

        async store({ commit, dispatch }, payload) {
            try {
                await axios.post("api/titles", payload);
                await dispatch("index");
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async update({ commit, dispatch }, payload) {
            try {
                const { data } = await axios.patch(`api/titles/${payload.id}`, payload);
                if (data.data.error) {
                    commit("addMessage", data.data.message);
                } else {
                    await dispatch("index");
                }
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },

        async destroy({ commit, dispatch }, id) {
            try {
                const { data } = await axios.delete(`api/titles/${id}`);
                if (data.data.error) {
                    commit("addMessage", data.data.message);
                } else {
                    await dispatch("index");
                }
            } catch (e) {
                commit("addErrors", errorHandler(e));
            }
        },
    },
};
