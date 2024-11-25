<template>
    <div>
        <header class="bg-indigo-500 text-white">
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
                    <!-- <img
                        class="avatar w-11 h-11 rounded-full"
                        :src="
                            $page.props.auth.user.avatar
                                ? 'storage/' + $page.props.auth.user.avatar
                                : 'storage/avatars/default.jpg'
                        "
                        alt=""
                    /> -->

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
                    <!-- <Link
                        :href="route('register')"
                        class="nav-link"
                        :class="{
                            'bg-slate-700 p-3 rounded':
                                $page.component === 'Auth/Register',
                        }"
                        >Register</Link
                    > -->
                    <!-- <Link
                        :href="route('main')"
                        class="nav-link"

                        >Main</Link
                    > -->
                    <Link
                        :href="route('login')"
                        class="nav-link"
                        :class="{
                            'bg-slate-700 p-3 rounded':
                                $page.component === 'Auth/Login',
                        }"
                        >login</Link
                    >
                </div>
            </nav>
        </header>
        <main class="p-4">
            <slot />
        </main>
    </div>
</template>
<script setup>
import { Link } from "@inertiajs/vue3";
import { route } from "../../../vendor/tightenco/ziggy/src/js";
</script>
