<template>
    <button class="btn btn-success btn-bg">
        <slot>
            <i class="fa-solid fa-xmark"></i>
        </slot>
    </button>
</template>

<script>
export default {
    name: "AppButtonCancel",
};
</script>

<style scoped>
.btn {
    padding: 0.4rem 2rem;
}
.btn-bg {
    background: #e1b4b1;
    border: solid 1px #e1b4b1;
    color: #555555;
}
.btn-bg:focus {
    box-shadow: 0px 0px 2px 1px #e08f8a;
}
</style>
