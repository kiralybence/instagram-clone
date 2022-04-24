<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Comment from "../../Components/Comment";
</script>

<template>
    <AppLayout title="Comments" :display-navbar="false">
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
