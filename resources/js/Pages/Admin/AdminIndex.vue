<template>
    <Head title=" | Dashboard"></Head>
    <h1> Welcome {{$page.props.auth.user.name }}</h1>
    <div id="home">
        <div class="lg:flex justify-between items-center mb-6">

        </div>

        <div class="flex flex-wrap -mx-3 mb-20">

        </div>

        <div class="flex flex-wrap -mx-3">

        </div>
    </div>
</template>

<script setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
defineOptions({ layout: AdminLayout });
</script>
