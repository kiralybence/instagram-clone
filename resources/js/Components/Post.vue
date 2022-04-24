<template>
    <div class="mb-3">
        <!-- Uploader -->
        <div class="flex justify-between p-3">
            <!-- Left -->
            <div class="flex">
                <img :src="post.user.profile_photo_url" class="rounded-full" style="width: 30px; height: 30px;">
                <span class="ml-3">{{ post.user.name }}</span>
            </div>

            <!-- Right -->
            <div class="flex">
                ...
            </div>
        </div>

        <!-- Image -->
        <div class="w-full">
            <img :src="post.image.url" class="w-full" @dblclick="toggleLikeStatus">
        </div>

        <!-- Below image -->
        <div class="p-3">
            <!-- Actions -->
            <div class="flex justify-between" style="font-size: 1.5rem;">
                <!-- Left -->
                <div class="flex">
                    <!-- Like -->
                    <i
                        class="fa-heart mr-3 cursor-pointer"
                        :class="{
                            'fa-regular': !post.is_liked,
                            'fa-solid': post.is_liked,
                        }"
                        @click="toggleLikeStatus"
                    ></i>

                    <!-- Comment -->
                    <!-- TODO: use <Link> instead of $inertia.visit, temporarily solution because of CSS -->
                    <i
                        class="fa-regular fa-comment mr-3 cursor-pointer"
                        @click="$inertia.visit(`/posts/${post.id}/comments`)"
                    ></i>

                    <!-- Send -->
                    <i class="fa-regular fa-paper-plane mr-3 cursor-pointer"></i>
                </div>

                <!-- Right -->
                <div class="flex">
                    <!-- Save -->
                    <i class="fa-regular fa-bookmark ml-3 cursor-pointer"></i>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-3">
                <b>{{ post.like_count }} {{ post.like_count !== 1 ? 'likes' : 'like' }}</b><br> <!-- TODO: maybe display "Be the first one to like" if there are 0 likes -->
                <b>{{ post.user.name }}</b> {{ post.description }}<br>
                <span style="color: darkgray;">{{ post.created_at_ago }}</span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Post",
    props: {
        post: Object,
    },
    methods: {
        async toggleLikeStatus() {
            await axios.post(`/api/posts/${this.post.id}/like`, {
                status: !this.post.is_liked,
            }).then(() => {
                this.post.is_liked = !this.post.is_liked;
                this.post.like_count += this.post.is_liked ? 1 : -1;
                // TODO: if coming from a double click event, play a heart animation on top of the image
            });
        },
    },
}
</script>

<style scoped>

</style>
