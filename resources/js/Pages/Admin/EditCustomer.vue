<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../components/TextInput.vue";

const props = defineProps({
    customer: {
        type: Object,
        default: () => ({}),
    },
});

const form = useForm({
    id: props.customer.id || null,
    name: props.customer.name || "",
    address: props.customer.address || "",
    mobile: props.customer.mobile || "",
    email: props.customer.email || "",
});

// Submit the form
const submit = () => {
    form.put(route("admin.updatecustomer", form.id), {
        onError: (errors) => {
            form.errors = errors; // Bind errors to form
            console.error(errors); // Optional: Log for debugging
        },
    });
};

</script>

<template>
    <Head title=" | Edit Customer" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">Edit Customer Details</h1>
        <form @submit.prevent="submit">
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
                :message="form.errors.email"
                readonly
            />

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
