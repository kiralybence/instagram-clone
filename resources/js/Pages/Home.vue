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
    </AppLayout>
</template>
