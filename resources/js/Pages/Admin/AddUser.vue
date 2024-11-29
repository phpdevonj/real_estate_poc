<script setup>
import { ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../components/TextInput.vue";

const Status = Object.freeze({
    Active: 1,
    Inactive: 0,
});

const props = defineProps({
    userTypes: Object, // Roles dropdown options
    status: {
        type: Number,
        default: null, // Default status value
    },
});

const emit = defineEmits(["update:status"]);

const form = useForm({
    username: null,
    address: null,
    mobile: null,
    name: null,
    email: null,
    password: null,
    avatar: null,
    status: null,
    role: null,
});

const fileError = ref(null);
const selectedRole = ref(form.role); // Manage roles dropdown
const selectedStatus = ref(form.status); // Local state for status dropdown

// Handle file input validation
const change = (e) => {
    const file = e.target.files[0];
    if (file.size > 3072 * 1024) {
        fileError.value = "File size should not exceed 3 MB.";
        form.avatar = null;
        form.preview = null;
    } else {
        fileError.value = null;
        form.avatar = file;
        form.preview = URL.createObjectURL(file);
    }
};

// Sync status changes
const updateStatus = (value) => {
    form.status = value;
    // any other logic for handling status change
};

// Submit the form
const submit = () => {
    if (fileError.value) {
        return; // Prevent submission if there's a file error
    }
    form.post(route("admin.adduser"), {
        onError: (errors) => {
            console.error(errors);
        },
        onSuccess: () => {
            form.reset(); // Clear form values after successful submission
        },
    });
};

// Reset the form
const cancel = () => {
    form.reset();
};
</script>

<template>
    <Head title=" | Add User" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">Create User</h1>
        <form @submit.prevent="submit">
            <div class="grid place-items">
                <div
                    class="relative w-28 h-28 rounded-full overflow-hidden border border-slate-300"
                >
                    <label
                        for="avatar"
                        class="absolute inset-0 grid content-end cursor-pointer"
                    >
                        <span class="bg-white/70 pb-2 text-center">Avatar</span>
                    </label>
                    <input type="file" id="avatar" @input="change" hidden />
                    <img
                        class="object-cover w-28 h-28"
                        :src="form.preview ?? '/storage/avatars/default.jpg'"
                    />
                </div>
                <p class="error mt-2">{{ form.errors.avatar }}</p>
            </div>
            <div v-if="fileError" class="text-red-500 mt-2">
                {{ fileError }}
            </div>
            <TextInput
                name="Username"
                v-model="form.username"

            />
            <TextInput
                name="Name"
                v-model="form.name"
                :message="form.errors.name"
            />
            <TextInput
                name="Address"
                v-model="form.address"

            />
            <TextInput
                name="Mobile"
                v-model="form.mobile"
                :message="form.errors.mobile"
            />
            <TextInput
                name="Email"
                v-model="form.email"
                :message="form.errors.email"
            />
            <TextInput
                name="Password"
                v-model="form.password"
                :message="form.errors.password"
            />
            <!-- Status Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="status" class="w-48">Status</label>
                <select
                    id="status"
                    v-model="form.status"
                    @change="updateStatus($event.target.value)"
                    class="w-96"
                >
                    <option
                        v-for="[label, value] in Object.entries(Status)"
                        :key="value"
                        :value="value"
                    >
                        {{ label }}
                    </option>
                </select>
            </div>
            <!-- Roles Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="userType" class="w-48">Roles</label>
                <select id="userType" v-model="form.role" class="w-96">
                    <option
                        v-for="(value, key) in userTypes"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
            </div>


            <div class="flex justify-between mt-4">
                <button
                    class="bg-blue-400 p-3 rounded"
                    :disabled="form.processing"
                >
                    Submit
                </button>
                <button
                    type="button"
                    class="bg-gray-400 p-3 rounded"
                    :disabled="form.processing"
                    @click="cancel"
                >
                    Cancel
                </button>
            </div>
        </form>
    </div>
</template>
