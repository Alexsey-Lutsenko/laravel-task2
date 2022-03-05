<template>
    <button class="btn btn-success btn-bg">
        <slot></slot>
    </button>
</template>

<script>
export default {
    name: "AppButtonSuccess",
};
</script>

<style scoped>
.btn {
    padding: 0.4rem 2rem;
}
.btn-bg {
    background: #bee1b1;
    border: solid 1px #bee1b1;
    color: #555555;
}
.btn-bg:focus {
    box-shadow: 0px 0px 2px 1px #89da6c;
}
</style>
