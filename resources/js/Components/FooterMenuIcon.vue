<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <div class="w-full text-center">
        <Link :href="href">
            <div class="w-full">
                <slot />
            </div>
        </Link>
    </div>
</template>

<script>
export default {
    name: 'FooterMenuIcon',
    props: [
        'href',
    ],
}
</script>
