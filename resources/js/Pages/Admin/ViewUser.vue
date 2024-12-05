
<template>
    <Head :title="' | Users List'" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">View Users List</h1>
        <div class="">
            <table class="w-full mx-auto p-2">
                <thead>
                    <tr class="bg-slate-300">
                        <th class="text-left p-2">Sr No</th>
                        <th class="text-left p-2">User Name</th>
                        <th class="text-left p-2">Name</th>
                        <th class="text-left p-2">Address</th>
                        <th class="text-left p-2">Mobile</th>
                        <th class="text-left p-2">Email</th>
                        <th class="text-left p-2">Role</th>
                        <th class="text-left p-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(user, index) in users.data" :key="user.id">
                        <td class="p-2">{{ users.from + index }}</td>
                        <td>{{ user.username }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.address }}</td>
                        <td>{{ user.mobile }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ userTypes[user.role] }}</td>
                        <td class="px-6 py-4 whitespace-no-wrap text-sm leading-5 text-gray-900">
                            <Link :href="route('admin.edituser',user.id)" class="px-2 py-1 bg-blue-600 text-white rounded font-bold uppercase mr-2">Edit</Link>
                            <Link
                                :href="route('admin.deleteuser', user.id)"
                                method="delete"
                                as="button"
                                class="px-2 py-1 bg-red-600 text-white rounded font-bold uppercase mr-2"
                                @click.prevent="confirmDelete(user.id)"
                            >
                                Delete
                            </Link></td>
                    </tr>
                </tbody>
            </table>
            <div class="w-full mx-auto p-2">
            <Link
                v-for="link in users.links"
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
                Showing {{ users.from }} to {{ users.to }} of {{ users.total }}
            </p>
        </div>
        </div>
    </div>
</template>
<script setup>
const props = defineProps({
    users: Array,
    userTypes: Object,
});
const confirmDelete = (id) => {
    if (confirm("Are you sure you want to delete this user?")) {
        router.delete(route('admin.deleteuser', id));
    }
};
</script>
