<script setup>
import FooterMenuIcon from './FooterMenuIcon';
</script>

<template>
    <div class="flex justify-between items-center fixed bottom-0 w-full bg-black text-white py-2" style="font-size: 1.3rem; border-top: 1px solid #474747;">
        <!-- TODO: icons should be solid when active, regular when not active -->

        <FooterMenuIcon :href="route('home')">
            <i class="fa-solid fa-house"></i>
        </FooterMenuIcon>

        <FooterMenuIcon href="#">
            <i class="fa-solid fa-magnifying-glass"></i>
        </FooterMenuIcon>

        <FooterMenuIcon href="#">
            <i class="fa-solid fa-plus"></i>
        </FooterMenuIcon>

        <FooterMenuIcon href="#">
            <i class="fa-solid fa-bag-shopping"></i>
        </FooterMenuIcon>

        <FooterMenuIcon href="#">
            <i class="fa-solid fa-user"></i>
        </FooterMenuIcon>
    </div>
</template>

<script>
export default {
    name: 'FooterMenu',
}
</script>
