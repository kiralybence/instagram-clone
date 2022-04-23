<template>
    <div class="flex justify-between p-3">
        <div class="flex">
            <!-- Left -->
            <img :src="comment.user.profile_photo_url" class="rounded-full" style="width: 30px; height: 30px;">

            <!-- Center -->
            <div class="pl-3">
                <span class="mr-1">
                    <b>{{ comment.user.name }}</b>
                </span>

                {{ comment.content }}

                <div style="color: darkgray;">
                    <span class="mr-5">
                        {{ comment.created_at_ago }}
                    </span>

                    <span class="mr-5">
                        {{ comment.like_count }} {{ comment.like_count !== 1 ? 'likes' : 'like' }}
                    </span>

                    <span class="mr-5">
                        Reply
                    </span>
                </div>
            </div>
        </div>

        <!-- Right -->
        <div class="align-middle">
            <!-- Like -->
            <i
                class="fa-heart cursor-pointer"
                :class="{
                    'fa-regular': !comment.is_liked,
                    'fa-solid': comment.is_liked,
                }"
                @click="toggleLikeStatus"
            ></i>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comment",
    props: {
        comment: Object,
    },
    methods: {
        async toggleLikeStatus() {
            await axios.post(`/api/comments/${this.comment.id}/like`, {
                status: !this.comment.is_liked,
            }).then(() => {
                this.comment.is_liked = !this.comment.is_liked;
                this.comment.like_count += this.comment.is_liked ? 1 : -1;
            });
        },
    },
}
</script>

<style scoped>

</style>
