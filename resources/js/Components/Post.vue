<template>
    <div class="mb-3">
        <!-- Uploader -->
        <div class="flex align-middle justify-between p-3">
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
            <img :src="post.image.url" class="w-full">
        </div>

        <!-- Below image -->
        <div class="p-3">
            <!-- Actions -->
            <div class="flex align-middle justify-between" style="font-size: 1.5rem;">
                <!-- Left -->
                <div class="flex">
                    <!-- Like -->
                    <i class="fa-regular fa-heart mr-3"></i>

                    <!-- Comment -->
                    <i class="fa-regular fa-comment mr-3"></i>

                    <!-- Send -->
                    <i class="fa-regular fa-paper-plane mr-3"></i>
                </div>

                <!-- Right -->
                <div class="flex">
                    <!-- Save -->
                    <i class="fa-regular fa-bookmark ml-3"></i>
                </div>
            </div>

            <!-- Info -->
            <div class="mt-3">
                <b>1234 likes</b><br>
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
}
</script>

<style scoped>

</style>
