<template>
    <Head :title="' | Properties List'" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">View Properties List</h1>
        <div class="">
            <table class="w-full mx-auto p-2">
                <thead>
                    <tr class="bg-slate-300">
                        <th class="text-left p-2">Sr No</th>
                        <th class="text-left p-2">Title</th>
                        <th class="text-left p-2">Address</th>
                        <th class="text-left p-2">Price</th>
                        <th class="text-left p-2">Size</th>
                        <th class="text-left p-2">Status</th>
                        <th class="text-left p-2">Agent</th>
                        <th class="text-left p-2">Customer</th>
                        <th class="text-left p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(property, index) in properties.data" :key="property.id">
                        <td class="p-2">{{ properties.from + index }}</td>
                        <td>{{ property.title }}</td>
                        <td>{{ property.full_address }}</td>
                        <td>{{ property.formatted_price }}</td>
                        <td>{{ property.formatted_size }}</td>
                        <td>{{ property.flag ? "Sold" : "Available" }}</td>
                        <td>{{ property.agent?.name }}</td>
                        <td>{{ property.customer?.name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm leading-5">
                            <!-- Remove the extra template wrapper -->
                            <Link
                                v-if="user.role === 0"
                                :href="route('admin.editproperty', property.id)"
                                class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2"
                            >
                                Edit
                            </Link>

                            <button
                                v-if="user.role === 0"
                                @click="deleteProperty(property.id)"
                                class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase mr-2"
                            >
                                Delete
                            </button>
                            <!-- Show toggle status button for both admin and agent -->
                            <button
                                @click="togglePropertyStatus(property.id)"
                                :class="`px-2 py-1 text-white rounded font-bold uppercase ${
                                    property.flag
                                        ? 'bg-green-600'
                                        : 'bg-yellow-600'
                                }`"
                            >
                                {{ property.flag ? "Mark Sold" : "Mark Available" }}
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="w-full mx-auto p-2">
                <Link
                    v-for="link in properties.links"
                    :key="link.label"
                    v-html="link.label"
                    :href="link.url"
                    class="p-1 m-1"
                    :class="{
                        'text-slate-300': !link.url,
                        'text-blue-500 font-medium': link.active,
                    }"
                >
                </Link>
                <p class="text-slate-600 text-sm">
                    Showing {{ properties.from }} to {{ properties.to }} of
                    {{ properties.total }}
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { router } from "@inertiajs/vue3";
import { onMounted } from "vue";

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    properties: {
        type: Array,
        required: true
    }
});

const deleteProperty = (id) => {
    if (confirm("Are you sure you want to delete this property?")) {
        router.delete(route("admin.deleteproperty", id));
    }
};

const togglePropertyStatus = (id) => {
    router.put(route("admin.togglepropertystatus", id));
};

// onMounted(() => {
//     console.log('Component mounted');
//     console.log('User details:', props.user);
//     console.log('Can edit/delete:', props.user.role === 0);
// });
</script>
