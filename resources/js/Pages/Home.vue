<script setup>
import AppLayout from '../Layouts/AppLayout.vue';
import Post from '../Components/Post';
import StoryBadge from '../Components/StoryBadge';
import Separator from '../Components/Separator';
</script>

<template>
    <AppLayout title="Home">
        <!-- Stories -->
        <div class="flex mb-3">
            <StoryBadge />
            <StoryBadge />
            <StoryBadge />
        </div>

        <Separator />

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
