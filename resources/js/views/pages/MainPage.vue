<template>
    <div class="d-flex justify-content-center mt-4">
        <h1>Главная</h1>
    </div>

    <div class="d-flex justify-content-center mt-4" v-if="loader">
        <app-loader class="my-5" v-if="loader"></app-loader>
    </div>

    <div v-if="!loader">
        <div class="d-flex justify-content-center align-items-center mt-4 flex-column">
            <div class="block-title">
                <div v-for="title of titles" :key="title.id">
                    <span class="mx-2" :class="{ active: titleId == title.id }" @click.prevent="getTitle(title.id)">{{ title.title }}</span>
                </div>
            </div>
            <div class="mt-2 block-title" v-if="titleDescription">
                <h6 class="m-0 mb-1">Описание темы: {{ titleDescription }}</h6>
                <div>
                    <button v-if="titleDescription !== 'Тема не выбрана'" class="btn btn-getTitle" @click.prevent="getTitlePage(titleId, 1)">
                        Перейти к теме
                    </button>
                    <button v-if="titleDescription !== 'Тема не выбрана'" class="btn btn-getTitle" @click.prevent="getTitlePage(titleId, 2)">
                        Посмотреть тему в галереи
                    </button>
                </div>
            </div>

            <div class="block-images mt-3">
                <div v-for="image of images.data" :key="image.id">
                    <img class="mx-2 my-2" :src="image.url" width="255" height="189" @click.prevent="getTitle(image.title_id)" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, onMounted, computed, watch } from "vue";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default {
    setup() {
        const store = useStore();
        const router = useRouter();
        const titleId = ref(null);
        const titleDescription = ref("Тема не выбрана");

        const images = computed(() => store.getters["image/getImages"]);
        const titles = computed(() => store.getters["title/getTitles"].filter((title) => title.cnt_images > 0));
        const loader = computed(() => store.getters["getLoader"]);
        watch(loader, () => {});

        onMounted(async () => {
            await store.dispatch("image/index", { random: 8 });
            await store.dispatch("title/index");
        });

        return {
            titles,
            loader,
            images,
            titleId,
            titleDescription,
            getTitle: (id) => {
                window.scrollTo(0, 0);
                titleId.value = id;

                if (id) {
                    titleDescription.value = titles.value.find((title) => title.id == id).description ?? "У этой темы еще нет описания";
                } else {
                    titleDescription.value = "Тема не выбрана";
                }
            },
            getTitlePage: (id, page) => {
                let title = titles.value.find((title) => title.id == id);
                store.commit("title/addTitle", title);

                if (page == 1) {
                    router.push("/title");
                } else {
                    router.push("/gallery");
                }
            },
        };
    },
};
</script>

<style lang="scss" scoped>
.block-title {
    display: flex;
    justify-content: center;
    max-width: 500px;
    flex-wrap: wrap;
}
.block-title div,
.block-images img {
    cursor: pointer;
}
.block-images {
    display: flex;
    justify-content: center;
    max-width: 900px;
    flex-wrap: wrap;
}
.active {
    color: #000000;
}
.btn-getTitle {
    font-size: 10px;
    padding: 1px;
    margin-left: 10px;
    border: 1px solid #555555;
    &:focus {
        box-shadow: none;
    }
    &:hover {
        background: #dee2e6;
    }
}
</style>
