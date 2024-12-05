<template>
    <Head :title="' | Customers List'" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">View Customers List</h1>
        <div class="">
            <table class="w-full mx-auto p-2">
                <thead>
                    <tr class="bg-slate-300">
                        <th class="text-left p-2">Sr No</th>
                        <th class="text-left p-2">Name</th>
                        <th class="text-left p-2">Address</th>
                        <th class="text-left p-2">Mobile</th>
                        <th class="text-left p-2">Email</th>
                        <th class="text-left p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(customer, index) in customers.data" :key="customer.id">
                        <td class="p-2">{{ customers.from + index }}</td>
                        <td>{{ customer.name }}</td>
                        <td>{{ customer.address }}</td>
                        <td>{{ customer.mobile }}</td>
                        <td>{{ customer.email }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            <Link :href="route('admin.editcustomer',customer.id)" class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Edit</Link>
                            <Link
                                :href="route('admin.deletecustomer', customer.id)"
                                method="delete"
                                as="button"
                                class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase mr-2"
                                @click.prevent="confirmDelete(customer.id)"
                            >
                                Delete
                            </Link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="w-full mx-auto p-2">
            <Link
                v-for="link in customers.links"
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
                Showing {{ customers.from }} to {{ customers.to }} of {{ customers.total }}
            </p>
        </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
  customers: Array, // Expecting an array directly, not an object with a 'data' property
});
const confirmDelete = (id) => {
    if (confirm('Are you sure you want to delete this customer?')) {
        router.delete(route('admin.deletecustomer', id));
    }
};
</script>
