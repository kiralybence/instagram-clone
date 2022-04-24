<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <!-- Main container -->
    <div
        :class="{
            'mb-3': !comment.is_reply,
        }"
    >
        <!-- Parent comment container -->
        <div
            class="flex p-3"
            :class="{
                'ml-10': comment.is_reply,
            }"
        >
            <!-- Left -->
            <img :src="comment.user.profile_photo_url" class="rounded-full" style="width: 30px; height: 30px;">

            <!-- Center -->
            <div class="pl-3 w-full">
                <b>{{ comment.user.name }}</b>

                <span
                    class="text-blue-100"
                    v-if="comment.is_reply"
                >
                    <Link href="#">
                        @{{ comment.parent.user.name }}
                    </Link>
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

            <!-- Right -->
            <div class="mx-3">
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

        <!-- Show replies button -->
        <div
            class="ml-14"
            style="color: darkgray;"
            v-if="!showReplies && !comment.is_reply && comment.replies.length > 0"
        >
            <span
                class="cursor-pointer flex items-center w-fit"
                @click="showReplies = true"
            >
                <hr
                    class="mr-2"
                    style="
                        width: 15px;
                        border-color: #3f3f3f;
                    "
                >

                <b>View {{ comment.replies.length }} more {{ comment.replies.length !== 1 ? 'replies' : 'reply' }}</b>
            </span>
        </div>

        <!-- Replies -->
        <Comment
            v-for="comment in comment.replies"
            :comment="comment"
            v-if="showReplies"
        />

        <!-- Hide replies button -->
        <div
            class="ml-14"
            style="color: darkgray;"
            v-if="showReplies && !comment.is_reply && comment.replies.length > 0"
        >
            <span
                class="cursor-pointer flex items-center w-fit"
                @click="showReplies = false"
            >
                <hr
                    class="mr-2"
                    style="
                        width: 15px;
                        border-color: #3f3f3f;
                    "
                >

                <b>Hide replies</b>
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Comment",
    props: {
        comment: Object,
    },
    data() {
        return {
            showReplies: false,
        };
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
