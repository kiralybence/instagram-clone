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
                <!-- Send in DMs -->
                <Link href="#">
                    <span class="text-blue-500">
                        <b>Share</b>
                    </span>
                </Link>
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
                    <img
                        :src="imagePreviewUrl"
                        class="max-w-full max-h-full"
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
                    ></textarea>
                </div>
            </div>

            <Separator />
        </div>
    </AppLayout>
</template>

<script>
export default {
    data() {
        return {
            imagePreviewUrl: null,
        };
    },
    methods: {
        onImageSelect(event) {
            if (!event.target.files) {
                return;
            }

            this.imagePreviewUrl = URL.createObjectURL(event.target.files[0]);
        },
    },
}
</script>

<style scoped>
    #captionInput::placeholder {
        color: #919191;
    }
</style>
