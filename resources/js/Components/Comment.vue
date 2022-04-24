<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div
        :class="{
            'mb-3': !comment.is_reply,
        }"
    >
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
            <div class="align-middle ml-3">
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

        <div
            class="ml-14"
            v-if="!showReplies && !comment.is_reply && comment.replies.length > 0"
        >
            <span
                class="cursor-pointer"
                @click="showReplies = true"
            >
                View {{ comment.replies.length }} more {{ comment.replies.length !== 1 ? 'replies' : 'reply' }}
            </span>
        </div>

        <!-- Replies -->
        <Comment
            v-for="comment in comment.replies"
            :comment="comment"
            v-if="showReplies"
        />
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
