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

        <!-- TODO: refactor - parent container should have the 100px height and the child divs should fill up the available height -->
        <div class="flex items-center p-3">
            <div
                class="mr-3"
                style="
                    width: 100px;
                    height: 100px;
                    background-image: url('https://via.placeholder.com/500x800');
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                "
            ></div>

            <div
                class="w-full"
                style="height: 100px;"
            >
                <textarea
                    class="w-full h-full"
                ></textarea>
            </div>
        </div>

        <Separator />

        test
    </AppLayout>
</template>

<script>
export default {
    //
}
</script>
