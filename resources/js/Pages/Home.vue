<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
</script>

<template>
    <AppLayout title="Home">
        <!-- Stories -->
        <div class="flex mb-3">
            <!-- Container -->
            <div class="text-center mx-2">
                <!-- Icon -->
                <div
                    class="rounded-full"
                    style="
                        width: 60px;
                        height: 60px;
                        border: 2px solid #474747;
                        padding: 3px;
                    "
                >
                    <img src="https://via.placeholder.com/150x150" class="rounded-full mb-1 w-full h-full">
                </div>

                <!-- Username -->
                <span style="font-size: 0.6rem;">Your story</span>
            </div>

            <!-- Container -->
            <div class="text-center mx-2">
                <!-- Icon -->
                <div
                    class="rounded-full"
                    style="
                        width: 60px;
                        height: 60px;
                        border: 2px solid #474747;
                        padding: 3px;
                    "
                >
                    <img src="https://via.placeholder.com/150x150" class="rounded-full mb-1 w-full h-full">
                </div>

                <!-- Username -->
                <span style="font-size: 0.6rem;">TODO</span>
            </div>
        </div>

        <hr style="border-top: 1px solid #474747;">

        <!-- Post -->
        <div>
            <!-- Uploader -->
            <div class="flex align-middle justify-between p-3">
                <div class="flex">
                    <img src="https://via.placeholder.com/150x150" class="rounded-full" style="width: 30px; height: 30px;">
                    <span class="ml-3">username</span>
                </div>

                <div class="flex">
                    ...
                </div>
            </div>

            <!-- Image -->
            <div>
                <img src="https://via.placeholder.com/800x800">
            </div>

            <!-- Actions -->
            <div class="flex align-middle justify-between p-3" style="font-size: 1.5rem;">
                <div class="flex">
                    <!-- Like -->
                    <i class="fa-regular fa-heart mr-3"></i>

                    <!-- Comment -->
                    <i class="fa-regular fa-comment mr-3"></i>

                    <!-- Send -->
                    <i class="fa-regular fa-paper-plane mr-3"></i>
                </div>

                <div class="flex">
                    <!-- Save -->
                    <i class="fa-regular fa-bookmark ml-3"></i>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
