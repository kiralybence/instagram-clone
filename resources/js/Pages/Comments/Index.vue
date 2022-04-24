<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Comment from "../../Components/Comment";
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <AppLayout title="Comments" :display-navbar="false">
        <!-- Header -->
        <div class="flex justify-between items-center px-3" style="height: 50px;">
            <!-- Left -->
            <div style="font-size: 1.5rem;">
                <!-- TODO: make route().back() working -->
                <Link href="#">
                    <i class="fa-solid fa-angle-left"></i>
                </Link>
            </div>

            <!-- Center -->
            <div style="font-size: 1.2rem;">
                Comments
            </div>

            <!-- Right -->
            <div class="flex items-center" style="font-size: 1.5rem;">
                <!-- Send in DMs -->
                <Link href="#">
                    <i class="fa-regular fa-paper-plane mr-2"></i>
                </Link>
            </div>
        </div>

        <hr style="border-top: 1px solid #474747;">

        <!-- Post description -->
        <div class="flex p-3">
            <!-- Left -->
            <img :src="post.user.profile_photo_url" class="rounded-full" style="width: 30px; height: 30px;">

            <!-- Center -->
            <div class="pl-3 w-full">
                <b>{{ post.user.name }}</b>

                {{ post.description }}

                <div style="color: darkgray;">
                    <span class="mr-5">
                        {{ post.created_at_ago_short }}
                    </span>
                </div>
            </div>
        </div>

        <hr style="border-top: 1px solid #474747;">

        <!-- Comments -->
        <Comment
            v-for="comment in post.comments.filter(comment => !comment.is_reply)"
            :comment="comment"
        />
    </AppLayout>
</template>

<script>
export default {
    props: {
        post: Object,
    },
}
</script>
