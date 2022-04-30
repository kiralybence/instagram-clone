<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import Post from '../Components/Post';
import StoryBadge from '../Components/StoryBadge';
</script>

<template>
    <AppLayout title="Home">
        <!-- Stories -->
        <div class="flex mb-3">
            <StoryBadge />
            <StoryBadge />
            <StoryBadge />
        </div>

        <hr style="border-top: 1px solid #474747;">

        <!-- Posts -->
        <Post v-for="post in posts" :post="post" />
    </AppLayout>
</template>

<script>
export default {
    props: {
        posts: Array,
    },
}
</script>
