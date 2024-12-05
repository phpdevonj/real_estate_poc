<script setup>
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

const user = computed(() => usePage().props.auth.user);
const isAdmin = computed(() => user.value?.role === 0);
const isAgent = computed(() => user.value?.role === 1); // Direct comparison with 0
</script>

<template>
    <div class="sidebar">
        <!-- Common links for both Admin and Agent -->
        <div class="w-1/2 md:w-1/3 lg:w-64 fixed md:top-0 md:left-0 h-screen lg:block bg-gray-100 border-r z-30">
            <div class="w-full h-20 border-b flex px-4 items-center mb-8">
                <a class="font-semibold text-3xl text-blue-400 pl-4">LOGO</a>
            </div>

            <!-- Dashboard Section -->
            <div class="mb-4 px-4" v-if="isAdmin || isAgent">
                <div class="w-full flex items-center text-blue-400 h-10 pl-4 bg-gray-200 hover:bg-gray-200 rounded-lg cursor-pointer">
                    <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                        <path d="M18.121,9.88l-7.832-7.836c-0.155-0.158-0.428-0.155-0.584,0L1.842,9.913c-0.262,0.263-0.073,0.705,0.292,0.705h2.069v7.042c0,0.227,0.187,0.414,0.414,0.414h3.725c0.228,0,0.414-0.188,0.414-0.414v-3.313h2.483v3.313c0,0.227,0.187,0.414,0.413,0.414h3.726c0.229,0,0.414-0.188,0.414-0.414v-7.042h2.068h0.004C18.331,10.617,18.389,10.146,18.121,9.88"></path>
                    </svg>
                    <Link :href="route('admin.index')" class="text-gray-700">Dashboard</Link>
                </div>
            </div>

            <!-- Properties Section - Available for both roles -->
            <div class="mb-4 px-4" v-if="isAdmin || isAgent">
                <p class="pl-4 text-sm font-semibold mb-1">PROPERTIES</p>
                <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                    <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                        <path d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10"></path>
                    </svg>
                    <Link :href="route('admin.addproperty')" class="text-gray-700">Add Properties</Link>
                </div>
                <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                    <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                        <path d="M15.396,2.292H4.604c-0.212,0-0.385,0.174-0.385,0.386v14.646c0,0.212,0.173,0.385,0.385,0.385h10.792c0.211,0,0.385-0.173,0.385-0.385V2.677C15.781,2.465,15.607,2.292,15.396,2.292"></path>
                    </svg>
                    <Link :href="route('admin.viewproperty')" class="text-gray-700">View Properties</Link>
                </div>
            </div>

            <!-- Admin Only Sections -->
            <template v-if="isAdmin">
                <!-- Customers Section -->
                <div class="mb-4 px-4">
                    <p class="pl-4 text-sm font-semibold mb-1">CUSTOMERS</p>
                    <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                            <path d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10"></path>
                        </svg>
                        <Link :href="route('admin.addcustomer')" class="text-gray-700">Add Customers</Link>
                    </div>
                    <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                            <path d="M15.396,2.292H4.604c-0.212,0-0.385,0.174-0.385,0.386v14.646c0,0.212,0.173,0.385,0.385,0.385h10.792c0.211,0,0.385-0.173,0.385-0.385V2.677C15.781,2.465,15.607,2.292,15.396,2.292"></path>
                        </svg>
                        <Link :href="route('admin.viewcustomer')" class="text-gray-700">View Customers</Link>
                    </div>
                </div>

                <!-- Users Section -->
                <div class="mb-4 px-4">
                    <p class="pl-4 text-sm font-semibold mb-1">USERS</p>
                    <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                            <path d="M14.613,10c0,0.23-0.188,0.419-0.419,0.419H10.42v3.774c0,0.23-0.189,0.42-0.42,0.42s-0.419-0.189-0.419-0.42v-3.774H5.806c-0.23,0-0.419-0.189-0.419-0.419s0.189-0.419,0.419-0.419h3.775V5.806c0-0.23,0.189-0.419,0.419-0.419s0.42,0.189,0.42,0.419v3.775h3.774C14.425,9.581,14.613,9.77,14.613,10"></path>
                        </svg>
                        <Link :href="route('admin.adduser')" class="text-gray-700">Add Users</Link>
                    </div>
                    <div class="w-full flex items-center text-blue-400 h-10 pl-4 hover:bg-gray-200 rounded-lg cursor-pointer">
                        <svg class="h-6 w-6 fill-current mr-2" viewBox="0 0 20 20">
                            <path d="M15.396,2.292H4.604c-0.212,0-0.385,0.174-0.385,0.386v14.646c0,0.212,0.173,0.385,0.385,0.385h10.792c0.211,0,0.385-0.173,0.385-0.385V2.677C15.781,2.465,15.607,2.292,15.396,2.292"></path>
                        </svg>
                        <Link :href="route('admin.viewuser')" class="text-gray-700">View Users</Link>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<style scoped>
.sidebar {
    min-height: 100vh;
    position: relative;
    z-index: 30;
}

.sidebar a {
    text-decoration: none;
}

.sidebar .router-link-active {
    background-color: rgba(0, 0, 0, 0.1);
}
</style>
