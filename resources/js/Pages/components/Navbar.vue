<template>
    <div class="sticky top-0 z-40">
        <div
            class="w-full h-20 px-6 bg-gray-100 border-b flex items-center justify-between"
        >
            <!-- left navbar -->
            <div class="flex">
                <!-- mobile hamburger -->
                <div class="lg:hidden flex items-center mr-4">
                    <button
                        class="hover:text-blue-500 hover:border-white focus:outline-none navbar-burger"
                        @click="toggleSidebar()"
                    >
                        <svg
                            class="h-5 w-5"
                            v-bind:style="{ fill: 'black' }"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <title>Menu</title>
                            <path
                                d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z"
                            />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- right navbar -->
            <div class="flex items-center relative" :v-if="$page.props.auth.user">
                <img
                    :src="$page.props.auth.user.avatar
                                ? '/storage/' + $page.props.auth.user.avatar
                                : '/storage/avatars/default.jpg'"
                    class="w-12 h-12 rounded-full shadow-lg"
                    @click="dropDownOpen = !dropDownOpen"
                />
            </div>
        </div>

        <!-- dropdown menu -->
        <div
            class="absolute bg-gray-100 border border-t-0 shadow-xl text-gray-700 rounded-b-lg w-48 bottom-10 right-0 mr-6 top-16 table"
            :class="dropDownOpen ? '' : 'hidden'"
        >
            <a href="#" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
            <a href="#" class="block px-4 py-2 hover:bg-gray-200">Change Password</a>
            <Link class="block px-4 py-2 hover:bg-gray-200" method="post" :href="route('logout')">Logout</Link>
        </div>
        <!-- dropdown menu end -->
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3';
import { route } from '../../../../vendor/tightenco/ziggy/src/js';

export default {
    name: "Navbar",
    data() {
        return {
            dropDownOpen: false,
        };
    },
    methods: {
        toggleSidebar() {
            this.$store.dispatch("toggleSidebar");
        },
    },
};
</script>
