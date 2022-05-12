<script setup>
import AppLayout from '../../Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Separator from '../../Components/Separator';
</script>

<template>
    <AppLayout title="Comments" :display-navbar="false" :display-footer="false">
        <!-- Header -->
        <div class="flex justify-between items-center px-3" style="height: 50px;">
            <!-- Left -->
            <div style="font-size: 1.5rem;">
                <!-- TODO: redirect back instead of going to the homepage -->
                <Link :href="route('home')">
                    <i class="fa-solid fa-angle-left"></i>
                </Link>
            </div>

            <!-- Center -->
            <div style="font-size: 1.2rem;">
                New Post
            </div>

            <!-- Right -->
            <div class="flex items-center">
                <!-- Send in DMs -->
                <Link href="#">
                    <span class="text-blue-500">
                        <b>Share</b>
                    </span>
                </Link>
            </div>
        </div>

        <Separator />

        <!-- TODO: refactor - parent container should have the 100px height and the child divs should fill up the available height -->
        <div class="flex items-center p-3">
            <div
                class="flex items-center justify-center mr-3"
                style="
                    width: 100px;
                    height: 100px;
                    background-image: url('https://via.placeholder.com/500x800');
                    background-size: contain;
                    background-repeat: no-repeat;
                    background-position: center;
                "
            ></div>

            <div
                class="w-full"
                style="height: 100px;"
            >
                <textarea
                    class="w-full h-full"
                ></textarea>
            </div>
        </div>

        <Separator />

        test
    </AppLayout>
</template>

<script>
export default {
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
            // TODO: add frontend validation, don"t allow sending more than 2200 chars
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

            if (this.isReplying) {
                this.commentInput = `@${this.replyingTo.username} `;
            } else {
                this.commentInput = '';
            }

            document.querySelector('#commentInput').focus();
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

            // Reset "replying to" state
            this.setReplyingTo(null, null);

            // Unfocus the input
            document.querySelector('#commentInput').blur();

            axios.post(route('api.posts.comments.store', { post: this.post.id }), {
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
