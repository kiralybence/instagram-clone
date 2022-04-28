<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import Comment from "../../Components/Comment";
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <AppLayout title="Comments" :display-navbar="false">
        <!-- Header -->
        <div class="flex justify-between items-center px-3" style="height: 50px;">
            <!-- Left -->
            <div style="font-size: 1.5rem;">
                <!-- TODO: make route().back() working -->
                <Link href="#">
                    <i class="fa-solid fa-angle-left"></i>
                </Link>
            </div>

            <!-- Center -->
            <div style="font-size: 1.2rem;">
                Comments
            </div>

            <!-- Right -->
            <div class="flex items-center" style="font-size: 1.5rem;">
                <!-- Send in DMs -->
                <Link href="#">
                    <i class="fa-regular fa-paper-plane mr-2"></i>
                </Link>
            </div>
        </div>

        <hr style="border-top: 1px solid #474747;">

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
                        {{ post.created_at_ago_short }}
                    </span>
                </div>
            </div>
        </div>

        <hr style="border-top: 1px solid #474747;">

        <!-- Comments -->
        <Comment
            v-for="comment in post.comments.filter(comment => !comment.is_reply)"
            :comment="comment"
            @replying-to="data => { setReplyingTo(data.comment_id, data.username) }"
        />

        <!-- Footer -->
        <div class="fixed bottom-0 w-full bg-black">
            <!-- "Replying to" warning -->
            <div v-if="isReplying" class="flex justify-between items-center w-full px-4" style="height: 40px; background: #262626;">
                <div style="color: #727272;">
                    Replying to {{ replyingTo.username }}
                </div>

                <!-- TODO: it doesn't look like it's perfectly centered vertically -->
                <div
                    class="cursor-pointer"
                    style="font-size: 0.8rem;"
                    @click="setReplyingTo(null, null)"
                >
                    <i class="fa-solid fa-xmark"></i>
                </div>
            </div>

            <div class="flex justify-center items-center p-3" :style="{ 'border-top': !isReplying ? '1px solid #474747' : '0' }">
                <!-- Auth user avatar -->
                <img
                    :src="$page.props.user.profile_photo_url"
                    class="rounded-full mr-2"
                    style="width: 42px; height: 42px;"
                >

                <!-- Comment input -->
                <!-- TODO: whenever replying to a comment, automatically tag the user (and save it to the DB as well, instead of displaying it hardcoded) -->
                <input
                    type="text"
                    placeholder="Add a comment..."
                    class="bg-black rounded-full w-full pr-16"
                    style="border: 1px solid #474747;"
                    id="commentInput"
                    v-model="commentInput"
                    @focus="commentInputIsFocused = true"
                    @blur="commentInputIsFocused = false"
                    @keyup.enter="submitComment"
                >

                <!-- Submit button -->
                <!-- FIXME: when clicking on the button, the input loses focus and the button disappears before the click event could register -->
                <div
                    class="fixed cursor-pointer right-8 font-bold"
                    :class="{
                        'text-blue-200': !commentIsSubmittable,
                        'text-blue-500': commentIsSubmittable,
                    }"
                    v-if="commentInputIsFocused"
                    @click="submitComment"
                >
                    Post
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    props: {
        post: Object,
    },
    computed: {
        isReplying() {
            return this.replyingTo.comment_id !== null;
        },
        pageBottomPadding() {
            let padding = 67;

            if (this.isReplying) {
                padding += 40;
                padding -= 1; // Because the border-top property gets removed
            }

            return padding;
        },
        commentIsSubmittable() {
            // TODO: add frontend validation, don't allow sending more than 2200 chars
            return this.commentInput.trim().length > 0;
        },
    },
    data() {
        return {
            commentInput: '',
            commentInputIsFocused: false,
            replyingTo: {
                comment_id: null,
                username: null,
            },
        };
    },
    methods: {
        setReplyingTo(comment_id, username) {
            this.replyingTo.comment_id = comment_id;
            this.replyingTo.username = username;
        },
        submitComment() {
            if (!this.commentIsSubmittable) {
                return;
            }

            // We need the preserve this data, because they get reset before the axios call
            let content = this.commentInput;
            let parent_id = this.replyingTo.comment_id;
            let isReplying = this.isReplying;

            // Clear the input
            this.commentInput = '';

            // Unfocus the input
            document.querySelector('#commentInput').blur();

            // Reset "replying to" state
            this.setReplyingTo(null, null);

            axios.post(`/api/posts/${this.post.id}/comments`, {
                content: content,
                parent_id: parent_id,
            }).then(resp => {
                // Add new comment to state (without refreshing everything)
                if (isReplying) {
                    // TODO: force rerendering the Comment child component, because it doesn't seem to react to this
                    this.post.comments.find(comment => comment.id = parent_id).replies.push(resp.data);
                } else {
                    this.post.comments.push(resp.data);
                }

                // Scroll to the bottom of the page (to automatically view the new comment)
                //
                // For some reason, after .push() is done, the scrolling executes before the
                // DOM could be re-rendered, therefore it will scroll to the wrong position.
                // But wrapping it in a 0ms setTimeout() block solves this issue.
                setTimeout(() => {
                    window.scrollTo({ top: document.body.scrollHeight, behavior: 'smooth' });
                }, 0);
            });
        },
    },
}
</script>

<style scoped>
    #commentInput::placeholder {
        color: #626262;
    }
</style>

<style>
    /* We must use padding in order to avoid hiding content beneath the fixed footer. */
    main {
        /* TODO: use pageBottomPadding property */
        padding-bottom: 67px;
    }
</style>
