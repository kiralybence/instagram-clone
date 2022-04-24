<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Comment from "../../Components/Comment";
</script>

<template>
    <AppLayout title="Comments" :display-navbar="false">
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
                        {{ post.created_at_ago }}
                    </span>
                </div>
            </div>
        </div>

        <hr style="border-top: 1px solid #474747;">

        <!-- Comments -->
        <Comment v-for="comment in post.comments.filter(comment => !comment.is_reply)" :comment="comment" />
    </AppLayout>
</template>

<script>
export default {
    props: {
        post: Object,
    },
}
</script>
