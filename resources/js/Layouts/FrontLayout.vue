<template>
    <div>
        <FrontHeader></FrontHeader>
        <main class="">
            <slot />
        </main>
        <FrontFooter></FrontFooter>

    </div>
</template>
<script setup>
import FrontHeader from "../Pages/components/FrontHeader.vue";
import FrontFooter from "../Pages/components/FrontFooter.vue";
</script>
