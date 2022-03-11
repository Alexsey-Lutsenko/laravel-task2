<template>
    <div class="d-flex justify-content-center mt-4">
        <h1>Галерея</h1>
    </div>

    <div class="d-flex justify-content-center mt-4" v-if="loader">
        <app-loader class="my-5" v-if="loader"></app-loader>
    </div>

    <div v-if="!loader">
        <div class="d-flex justify-content-center mt-3" v-if="titleDescription">
            <h6>Описание темы: {{ titleDescription }}</h6>
        </div>

        <div class="rigth-menu">
            <ul class="pb-0">
                <li :class="{ active: titleId == null }" @click.prevent="getFilter(null)">Все</li>
            </ul>
            <ul class="nav-menu top-nav-menu">
                <li v-for="title of titles" :key="title.id" @click.prevent="getFilter(title.id)" :class="{ active: titleId == title.id }">
                    <span v-if="title.cnt_images > 0">{{ title.title }}</span>
                </li>
            </ul>
        </div>

        <div class="d-flex justify-content-center">
            <table class="table table-hover w-50">
                <thead>
                    <tr>
                        <th scope="col">Фото</th>
                        <th scope="col">Описание</th>
                        <th scope="col">Тема</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="image of images.data" :key="image.id">
                        <td><img :src="image.url" width="255" height="189" @click="showImage(image.url)" /></td>
                        <td>{{ image.description }}</td>
                        <td>{{ image.title }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="d-flex w-100 justify-content-center">
            <laravel-vue-pagination :data="images" @pagination-change-page="getResults"></laravel-vue-pagination>
        </div>
    </div>

    <Teleport to="body">
        <app-image-show :image="urlImage" @close="urlImage = null"></app-image-show>
    </Teleport>
</template>

<script>
import { ref, computed, onMounted, watch } from "vue";
import { useStore } from "vuex";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
    setup() {
        const store = useStore();
        const titleId = ref(null);
        const titleDescription = ref(null);
        const urlImage = ref(null);

        const images = computed(() => store.getters["image/getImages"]);
        const titles = computed(() => store.getters["title/getTitles"]);
        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(async () => {
            await store.dispatch("image/index");
            await store.dispatch("title/index");
        });

        return {
            images,
            loader,
            titles,
            titleId,
            titleDescription,
            urlImage,
            getFilter: (id) => {
                titleId.value = id;
                if (id) {
                    titleDescription.value = titles.value.find((title) => title.id == id).description;
                } else {
                    titleDescription.value = null;
                }
                store.dispatch("image/index", { title_id: id });
            },
            getResults: (page = 1) => {
                store.dispatch("image/index", { page: page, title_id: titleId.value });
            },
            showImage: (url) => {
                urlImage.value = url;
            },
        };
    },
    components: { LaravelVuePagination },
};
</script>

<style scoped>
.nav-menu a {
    text-decoration: none;
    color: #000000;
    font-size: 20px;
}
.rigth-menu {
    height: 100%;
    position: fixed;
    z-index: 1;
    top: 55px;
    left: 0;
    padding-top: 50px;
    margin-left: 295px;
}
.rigth-menu ul {
    padding: 2rem 1rem;
    list-style-type: none;
}
.rigth-menu ul li {
    font-size: 16px;
    margin-bottom: 5px;
    cursor: pointer;
}
.active {
    color: #000000;
}
</style>
