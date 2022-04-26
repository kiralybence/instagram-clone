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
        />

        <!-- Footer -->
        <div class="flex justify-center items-center p-3 fixed bottom-0 w-full bg-black" style="border-top: 1px solid #474747;">
            <!-- Auth user avatar -->
            <img
                :src="$page.props.user.profile_photo_url"
                class="rounded-full mr-2"
                style="width: 42px; height: 42px;"
            >

            <!-- Comment input -->
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
                    'text-blue-200': !commentIsSubmittable(),
                    'text-blue-500': commentIsSubmittable(),
                }"
                v-if="commentInputIsFocused"
                @click="submitComment"
            >
                Post
            </div>
        </div>
    </AppLayout>
</template>

<script>
export default {
    props: {
        post: Object,
    },
    data() {
        return {
            commentInput: '',
            commentInputIsFocused: false,
        };
    },
    methods: {
        commentIsSubmittable() {
            return this.commentInput.trim().length > 0;
        },
        submitComment() {
            if (!this.commentIsSubmittable()) {
                return;
            }

            // TODO: implement comment submission, leaving alert() here temporarily as a placeholder
            alert(this.commentInput);

            this.commentInput = '';
            document.querySelector('#commentInput').blur();
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
        padding-bottom: 67px;
    }
</style>
