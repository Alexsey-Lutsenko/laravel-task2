<template>
    <div class="d-flex justify-content-center mt-4">
        <h1>Тема: {{ title.title }}</h1>
    </div>

    <div class="d-flex justify-content-center mt-4" v-if="loader">
        <app-loader class="my-5" v-if="loader"></app-loader>
    </div>

    <div v-if="!loader">
        <div class="d-flex justify-content-center align-items-center mt-4 flex-column">
            <div>
                <router-link :to="'/'"><i class="fa-solid fa-angle-left"></i> Вернуться на главную</router-link>
            </div>
            <div class="mt-2">
                <h6 class="m-0 mb-1">Описание темы: {{ title.description }}</h6>
            </div>

            <div class="block-images mt-3">
                <div v-for="image of images.data" :key="image.id">
                    <img class="mx-2 my-2" :src="image.url" width="255" height="189" @click="showImage(image.url)" />
                </div>
            </div>
        </div>
    </div>

    <Teleport to="body">
        <app-image-show :image="urlImage" @close="urlImage = null"></app-image-show>
    </Teleport>
</template>

<script>
import { ref, computed, onMounted, watch } from "vue";
import { useStore } from "vuex";

export default {
    name: "TitlePage",
    setup() {
        const store = useStore();
        const urlImage = ref(null);

        const title = computed(() => store.getters["title/getTitle"]);
        const images = computed(() => store.getters["image/getImages"]);
        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(async () => {
            await store.dispatch("image/index", { title_id: title.value.id });
        });

        return {
            title,
            images,
            loader,
            urlImage,
            showImage: (url) => {
                urlImage.value = url;
            },
        };
    },
};
</script>

<style scoped>
.block-images {
    display: flex;
    justify-content: center;
    max-width: 900px;
    flex-wrap: wrap;
}
</style>
