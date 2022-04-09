<script setup>
import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, Link } from '@inertiajs/inertia-vue3';
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue';
import JetBanner from '@/Jetstream/Banner.vue';
import JetDropdown from '@/Jetstream/Dropdown.vue';
import JetDropdownLink from '@/Jetstream/DropdownLink.vue';
import JetNavLink from '@/Jetstream/NavLink.vue';
import JetResponsiveNavLink from '@/Jetstream/ResponsiveNavLink.vue';

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    Inertia.post(route('logout'));
};
</script>

<template>
    <div>
        <Head :title="title" />

        <JetBanner />

        <div class="min-h-screen bg-black text-white">
            <nav>
                <!-- Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Left -->
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center" style="font-size: 1.2rem;">
                                <Link :href="route('home')">
                                    <b>Instagram</b>
                                </Link>
                            </div>
                        </div>

                        <!-- Right -->
                        <div class="flex">
                            <!-- Icons -->
                            <div class="shrink-0 flex items-center" style="font-size: 1.5rem;">
                                <!-- Notifications -->
                                <Link :href="route('home')">
                                    <i class="fa-regular fa-heart ml-2"></i>
                                </Link>

                                <!-- DMs -->
                                <Link :href="route('home')">
                                    <i class="fa-regular fa-paper-plane ml-2"></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
