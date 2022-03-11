<template>
    <div class="d-flex justify-content-center">
        <h1>Фото</h1>
    </div>

    <div class="d-flex justify-content-center mt-3">
        <div class="d-flex">
            <div class="mt-3 mx-3 d-flex justify-content-center upload">
                <div ref="dropzoneEl" class="btn d-block p-5 bg-dark text-center text-light w-100">Upload</div>
            </div>
            <div class="input-block mx-2">
                <app-input v-model.trim="imageModel.description" type="text" placeholder="Описание"></app-input>
                <small class="text-danger error-text" v-if="errors.description">{{ errors.description }}</small>
            </div>
            <div class="input-block">
                <app-input v-model.trim="imageModel.title" type="text" placeholder="Тема"></app-input>
                <small class="text-danger error-text" v-if="errors.title">{{ errors.title }}</small>
            </div>
        </div>
        <div class="d-flex justify-content-center mx-2">
            <app-button-success class="button-style" @click.prevent="send"></app-button-success>
        </div>
        <div class="d-flex justify-content-center">
            <app-button-cancel class="button-style" @click.prevent="cancel"></app-button-cancel>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-5">
        <app-loader class="my-5" v-if="loader"></app-loader>
        <table class="table table-hover w-50" v-if="!loader">
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
                    <td>
                        <i class="fa-solid fa-user-pen add-icon-style" @click.prevent="update(image.id)"></i>
                    </td>
                    <td>
                        <i class="fa-regular fa-circle-xmark add-icon-style" @click.prevent="destroy(image.id)"></i>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="d-flex w-100 justify-content-center">
        <laravel-vue-pagination :data="images" @pagination-change-page="getResults"></laravel-vue-pagination>
    </div>

    <Teleport to="body">
        <app-image-show :image="urlImage" @close="urlImage = null"></app-image-show>
    </Teleport>
</template>

<script>
import { onMounted, computed, ref, watch } from "vue";
import { useStore } from "vuex";
import Dropzone from "dropzone";
import LaravelVuePagination from "laravel-vue-pagination";

export default {
    setup() {
        const store = useStore();
        const dropzone = ref(null);
        const dropzoneEl = ref(null);
        const imageModel = ref({ title: "", description: "", id: null });
        const typeFunction = ref(1);
        const urlImage = ref(null);

        const images = computed(() => store.getters["image/getImages"]);
        const loader = computed(() => store.getters["getLoader"]);
        const errors = computed(() => store.getters["image/getErrors"]);
        const errorCount = computed(() => store.getters["image/getErrorCount"]);
        watch(loader, () => {});

        onMounted(async () => {
            dropzone.value = new Dropzone(dropzoneEl.value, {
                autoProcessQueue: false,
                url: "/api/images/",
                addRemoveLinks: true,
                maxFiles: 1,
            });

            await store.dispatch("image/index");
        });

        const prewDrop = () => {
            let previews = dropzone.value.previewsContainer.querySelectorAll(".dz-image-preview");

            previews.forEach((preview) => {
                preview.remove();
            });
        };

        const update = (id) => {
            window.scrollTo(0, 0);
            prewDrop();
            typeFunction.value = 2;

            images.value.data.forEach((image) => {
                if (image.id == id) {
                    imageModel.value = Object.assign({}, image);

                    let file = { id: image.id, name: image.name, size: image.size };
                    dropzone.value.displayExistingFile(file, image.url);
                }
            });
        };

        return {
            dropzone,
            dropzoneEl,
            images,
            imageModel,
            loader,
            errors,
            errorCount,
            update,
            urlImage,
            typeFunction,
            send: async () => {
                if (typeFunction.value == 1) {
                    const data = new FormData();
                    const files = dropzone.value.getAcceptedFiles();
                    files.forEach((file) => {
                        data.append("images[]", file);
                        dropzone.value.removeFile(file);
                    });
                    data.append("title", imageModel.value.title);
                    data.append("description", imageModel.value.description);
                    imageModel.value = {};
                    store.dispatch("image/store", data);
                    prewDrop();
                } else if (typeFunction.value == 2) {
                    const data = new FormData();
                    const files = dropzone.value.getAcceptedFiles();
                    files.forEach((file) => {
                        data.append("images[]", file);
                        dropzone.value.removeFile(file);
                    });
                    data.append("title", imageModel.value.title);
                    data.append("description", imageModel.value.description);
                    data.append("_method", "PATCH");

                    await store.dispatch("image/update", { id: imageModel.value.id, formData: data });

                    imageModel.value = {};
                    prewDrop();
                    typeFunction.value == 1;
                }
            },
            getResults: (page = 1) => {
                store.dispatch("image/index", page);
            },
            destroy: async (id) => await store.dispatch("image/destroy", id),
            showImage: (url) => {
                urlImage.value = url;
            },
            cancel: () => {
                imageModel.value = {};
                prewDrop();
            },
        };
    },
    components: { LaravelVuePagination },
};
</script>

<style lang="scss" scoped>
.button-style {
    height: min-content;
}
.upload {
    min-width: 300px;
}
.add-icon-style {
    font-size: 18px;
    cursor: pointer;
    color: #555555;
    &:hover {
        color: #000000;
    }
}
.error-text {
    font-size: 10px;
}
</style>
