<script setup>
import { useForm } from "@inertiajs/vue3";
import TextInput from "../components/TextInput.vue";

const form = useForm({
    name: null,
    address: null,
    mobile: null,
    email: null,
});

// Submit the form
const submit = () => {
    form.post(route("admin.addcustomer"), {
        onError: (errors) => {(errors)},
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
    <Head title=" | Add Customer" />
    <div class="m-auto bg-slate-200 p-3">
        <!-- <p class="p-4 bg-green-400">{{ $page.props.flash.message }}</p> -->
        <h1 class="text-center">Create Customer</h1>
        <form @submit.prevent="submit">
            <TextInput name="Name" v-model="form.name" :message="form.errors.name" />
            <TextInput name="Address" v-model="form.address" :message="form.errors.address" />
            <TextInput name="Mobile" v-model="form.mobile" :message="form.errors.mobile" />
            <TextInput name="Email" v-model="form.email" :message="form.errors.email" />

            <div class="flex justify-between mt-4">
                <button class="bg-blue-400 p-3 rounded" :disabled="form.processing">
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
