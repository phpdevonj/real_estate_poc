<template>
    <div class="flex justify-between px-10">
        <h1>Welcome Real Estate</h1>
        <a class="bg-blue-400 p-3 rounded text-right" :href="route('admin.index')">
            Admin
        </a>
    </div>
</template>

<script setup>
import FrontLayout from '../Layouts/FrontLayout.vue';
defineOptions({ layout: FrontLayout });
</script>
