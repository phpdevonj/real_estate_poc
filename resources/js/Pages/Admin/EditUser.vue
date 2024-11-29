<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../components/TextInput.vue";
import { ref, watch, computed } from "vue";
import { router } from "@inertiajs/vue3";

const Status = Object.freeze({
    Active: 1,
    Inactive: 0,
});

const props = defineProps({
    user: {
        type: Object,
        default: () => ({}),
    },
    userTypes: Object,
    status: {
        type: Number,
        default: null,
    },
});

const emit = defineEmits(["update:status"]);
const form = useForm({
    id: props.user.id || null,
    avatar: props.user.avatar || "",
    username: props.user.username || "",
    name: props.user.name || "",
    address: props.user.address || "",
    mobile: props.user.mobile || "",
    email: props.user.email || "",
    password: "",
    status: props.user.status || 1,
    role: props.user.role || "",
});

const fileError = ref(null);
const selectedRole = ref(form.role);
const selectedStatus = ref(form.status);

const change = (e) => {
    const file = e.target.files[0];
    const allowedTypes = ["image/jpeg", "image/png", "image/jpg"]; // Allowed MIME types

    if (!allowedTypes.includes(file.type)) {
        fileError.value = "Invalid file type. Only JPG, JPEG, and PNG are allowed.";
        form.avatar = null;
        form.preview = null;
    } else if (file.size > 3072 * 1024) {
        fileError.value = "File size should not exceed 3 MB.";
        form.avatar = null;
        form.preview = null;
    } else {
        fileError.value = null;
        form.avatar = file;
        form.preview = URL.createObjectURL(file);
    }
};

const updateStatus = (value) => {
    form.status = value;
    emit("update:status", value);
};

watch(selectedStatus, (value) => {
    updateStatus(value);
});

const submit = () => {
    try {
            router.post(`/admin/updateuser/${form.id}`, {
                _method: 'put',
                id: form.id,
                avatar: form.avatar,
                username: form.username,
                name: form.name,
                address: form.address,
                mobile: form.mobile,
                //email: form.email,
                password: form.password,
                status: form.status,
                role: form.role,
            }, {
                onError: (errors) => {
                    form.errors = errors;
                },
            });
        } catch (error) {
            console.error("An unexpected error occurred:", error);
            form.errors.general = "An unexpected error occurred. Please try again later.";
        }

};
</script>

<template>
    <Head title=" | Edit User" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">Edit User Details</h1>
        <form @submit.prevent="submit">
            <div class="grid">
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
                        :src=" form.preview ||(form.avatar
                                ? '/storage/' + form.avatar
                                : '/storage/avatars/default.jpg')
                        "
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
                :message="form.errors.address"
            />
            <TextInput
                name="Mobile"
                v-model="form.mobile"
                :message="form.errors.mobile"
            />
            <TextInput
                name="Email"
                v-model="form.email"
                readonly
            />
            <TextInput
                name="Password"
                v-model="form.password"
                placeholder="Leave blank to keep current password"
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
                        :value="parseInt(key)"
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
                    Update
                </button>
            </div>
        </form>
    </div>
</template>
