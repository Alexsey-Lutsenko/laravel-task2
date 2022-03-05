<template></template>

<script>
import { defineComponent, computed, watch } from "vue";
import { useStore } from "vuex";
import { createToast } from "mosha-vue-toastify";
import "mosha-vue-toastify/dist/style.css";

export default {
    name: "AppToast",
    props: {
        text: [String],
        type: [String],
    },
    setup(props) {
        watch(text, (value) => {
            if (value) {
                createToast(props.text, {
                    type: props.type, // 'info', 'danger', 'warning', 'success', 'default'
                    timeout: 2000,
                    showCloseButton: true,
                    position: "top-right",
                    transition: "slide",
                    hideProgressBar: true,
                    swipeClose: true,
                    onClose: null,
                });
            }
        });
    },
};
</script>

<style>
.mosha__toast {
    top: 80px !important;
}
.mosha__toast__content__text {
    font-family: "Nunito", sans-serif !important;
    font-weight: 500;
    line-height: 1.2;
}
</style>
