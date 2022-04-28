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
            <Link :href="route('profile', { user: comment.user.name })">
                <img :src="comment.user.profile_photo_url" class="rounded-full" style="width: 30px; height: 30px;">
            </Link>

            <!-- Center -->
            <div class="pl-3 w-full">
                <span class="mr-1">
                    <Link :href="route('profile', { user: comment.user.name })">
                        <b>{{ comment.user.name }}</b>
                    </Link>
                </span>

                <span :id="`comment-content-container-${comment.id}`">
                    {{ comment.content }}
                </span>

                <div style="color: darkgray;">
                    <span class="mr-5">
                        {{ comment.created_at_ago_short }}
                    </span>

                    <span
                        class="mr-5"
                        v-if="comment.like_count > 0"
                    >
                        {{ comment.like_count }} {{ comment.like_count !== 1 ? 'likes' : 'like' }}
                    </span>

                    <span
                        class="mr-5 cursor-pointer"
                        @click="$emit('replyingTo', { comment_id: comment.id, username: comment.user.name })"
                    >
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
    mounted() {
        this.formatComment();
    },
    data() {
        return {
            showReplies: false,
        };
    },
    methods: {
        async toggleLikeStatus() {
            await axios.post(route('api.comments.like', { comment: this.comment.id }), {
                status: !this.comment.is_liked,
            }).then(() => {
                this.comment.is_liked = !this.comment.is_liked;
                this.comment.like_count += this.comment.is_liked ? 1 : -1;
            });
        },
        formatComment() {
            let container = document.querySelector(`#comment-content-container-${this.comment.id}`);

            container.innerHTML = container.innerHTML
                .split(' ')
                .map(word => {
                    // I cannot use <Link>, because it doesn't get rendered if the DOM is being updated manually

                    // Highlight tagged users
                    if (word.charAt(0) === '@') {
                        let username = word.slice(1);

                        word = this.highlightWord(route('profile', { user: username }), word);
                    }

                    // Highlight hashtags
                    if (word.charAt(0) === '#') {
                        let hashtag = word.slice(1);

                        word = this.highlightWord(route('hashtag', { hashtag: hashtag }), word);
                    }

                    return word;
                })
                .join(' ');
        },
        highlightWord(url, word) {
            return `<a href="${url}" class="text-blue-100">${word}</a>`
        },
    },
}
</script>

<style scoped>

</style>
