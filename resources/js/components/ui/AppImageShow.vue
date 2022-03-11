<template>
    <div class="image-mask" v-if="image" @click.prevent="$emit('close'), (image = null)">
        <div class="image-wrapper">
            <div class="image-container">
                <img :src="image" width="940" />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    emits: ["close"],
    props: {
        image: {
            type: String,
        },
    },
    name: "AppImageShow",
};
</script>

<style scoped>
.image-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
}
.image-wrapper {
    display: table-cell;
    vertical-align: middle;
}
.image-container {
    width: 1000px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
}
</style>
