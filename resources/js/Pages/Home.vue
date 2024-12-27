<template>
    <FrontHome
        :categories="property_categories"
        name="home"
    />
</template>

<script setup>
import FrontLayout from '../Layouts/FrontLayout.vue';
import FrontHome from './components/FrontHome.vue';

const props = defineProps({
    property_categories: {
        type: Array,
        required: true,
    }
});
defineOptions({ layout: FrontLayout });
</script>
