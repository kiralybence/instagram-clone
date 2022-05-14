<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Separator from '../../Components/Separator';
</script>

<template>
    <AppLayout title="Comments" :display-navbar="false" :display-footer="false">
        <!-- Header -->
        <div class="flex justify-between items-center px-3" style="height: 50px;">
            <!-- Left -->
            <div style="font-size: 1.5rem;">
                <!-- TODO: redirect back instead of going to the homepage -->
                <Link :href="route('home')">
                    <i class="fa-solid fa-angle-left"></i>
                </Link>
            </div>

            <!-- Center -->
            <div style="font-size: 1.2rem;">
                New Post
            </div>

            <!-- Right -->
            <div class="flex items-center">
                <!-- Submit post -->
                <span
                    class="cursor-pointer"
                    :class="{
                        'text-blue-200': !postIsSubmittable,
                        'text-blue-500': postIsSubmittable,
                    }"
                    @click="submitPost"
                >
                    <b>Share</b>
                </span>
            </div>
        </div>

        <Separator />

        <!-- TODO: align center -->
        <div
            v-if="!imagePreviewUrl"
            class="flex items-center justify-center"
        >
            <input type="file" @change="onImageSelect">
        </div>

        <div v-if="imagePreviewUrl">
            <div class="flex items-center p-3">
                <div
                    class="flex items-center justify-center mr-3"
                    style="width: 100px; height: 100px;"
                >
                    <!-- TODO: big preview on click -->
                    <img
                        :src="imagePreviewUrl"
                        class="max-w-full max-h-full cursor-pointer"
                    >
                </div>

                <div
                    class="w-full"
                    style="height: 100px;"
                >
                    <textarea
                        id="captionInput"
                        class="w-full h-full bg-black text-white border-0 resize-none outline-0"
                        placeholder="Write a caption..."
                        maxlength="2200"
                        v-model="caption"
                    ></textarea>
                </div>
            </div>

            <Separator />
        </div>
    </AppLayout>
</template>

<script>
export default {
    computed: {
        postIsSubmittable() {
            // TODO: add frontend validation
            return !!this.selectedImage && !this.postIsSubmitting && this.caption.length <= 2200;
        },
    },
    data() {
        return {
            selectedImage: null,
            imagePreviewUrl: null,
            caption: '',
            postIsSubmitting: false,
        };
    },
    methods: {
        onImageSelect(event) {
            if (!event.target.files) {
                return;
            }

            this.selectedImage = event.target.files[0];
            this.imagePreviewUrl = URL.createObjectURL(this.selectedImage);
        },
        submitPost() {
            if (!this.postIsSubmittable) {
                return;
            }

            this.postIsSubmitting = true;

            let formData = new FormData();
            formData.append('image', this.selectedImage);
            formData.append('description', this.caption);

            axios.post(route('api.posts.store'), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                },
            }).then(() => {
                this.$inertia.visit(route('home'));
            });
        },
    },
}
</script>

<style scoped>
    #captionInput::placeholder {
        color: #919191;
    }
</style>
