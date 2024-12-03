<template>
    <div>
        <!-- <header class="bg-indigo-500 text-white">
            <nav
                class="flex-item-center justify-between p-4 max-w-screen-lg mx-auto flex"
            >
                <div class="space-x-6">
                    <Link
                        :href="route('home')"
                        :class="{
                            'bg-slate-700 rounded p-3':
                                $page.component === 'Home',
                        }"
                        >Home</Link
                    >
                </div>
                <div v-if="$page.props.auth.user" class="space-x-6 flex">
                    
                    <Link
                        :href="route('logout')"
                        method="post"
                        as="button"
                        type="button"
                        class="nav-link"
                        >Logout</Link
                    >
                </div>
                <div v-else class="space-x-6">
                    
                    <Link
                        :href="route('login')"
                        class="nav-link"
                        :class="{
                            'bg-slate-700 p-3 rounded':
                                $page.component === 'Auth/Login',
                        }"
                        >Login</Link
                    >
                </div>
            </nav>
        </header> -->
        <FrontHeader></FrontHeader>
        <main class="">
            <FrontHome></FrontHome>
            <slot />
        </main>
        <FrontFooter></FrontFooter>

    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { route } from "../../../vendor/tightenco/ziggy/src/js";
import FrontHeader from "../Pages/components/FrontHeader.vue";
import FrontFooter from "../Pages/components/FrontFooter.vue";
import FrontHome from "../Pages/components/FrontHome.vue";
</script>
