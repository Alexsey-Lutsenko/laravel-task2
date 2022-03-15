/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");
import { createApp } from "vue";
import router from "./router";
import store from "./store";
import App from "./views/App";
import components from "./components/ui";

import Datepicker from "vue3-date-time-picker";

const app = createApp(App);

components.forEach((component) => {
    app.component(component.name, component);
});

app.component("Datepicker", Datepicker);

app.use(router).use(store).mount("#app");
