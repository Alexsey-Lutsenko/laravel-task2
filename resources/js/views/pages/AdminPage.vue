<template>
    <div class="d-flex align-items-center justify-content-center">
        <h1>AdminPage</h1>
    </div>
    <div class="w-25">
        <input v-model="title" type="text" class="form-control" placeholder="title" />
        <input v-model="description" type="text" class="form-control" placeholder="description" />
        <button class="btn btn-dark" @click="send">Upload</button>

        <div class="mt-3 d-flex justify-content-center">
            <div ref="dropzoneEl" class="btn d-block p-5 bg-dark text-center text-light">Upload</div>
        </div>
    </div>
    <div v-if="image">
        <h4>{{ image.title }}</h4>
        <div>
            <img :src="image.url" />
        </div>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import Dropzone from "dropzone";

export default {
    setup() {
        const dropzone = ref(null);
        const dropzoneEl = ref(null);
        const title = ref("");
        const description = ref("");
        const image = ref(null);

        const getImage = () => {
            axios.get("api/images").then((res) => (image.value = res.data.data));
        };

        onMounted(() => {
            dropzone.value = new Dropzone(dropzoneEl.value, {
                autoProcessQueue: false,
                url: "/api/images/",
                addRemoveLinks: true,
            });

            getImage();
        });

        return {
            title,
            dropzone,
            dropzoneEl,
            description,
            image,
            send: async () => {
                const data = new FormData();
                const files = dropzone.value.getAcceptedFiles();
                files.forEach((file) => {
                    data.append("images[]", file);
                    dropzone.value.removeFile(file);
                });
                data.append("title", title.value);
                title.value = "";
                data.append("description", description.value);
                description.value = "";

                await axios.post("/api/images", data).then((res) => {
                    getImage();
                });
            },
        };
    },
};
</script>

<style></style>
