<script setup>
import { useForm } from "@inertiajs/vue3";
import Textinput from "../components/TextInput.vue";
import FrontLayout from "../../Layouts/FrontLayout.vue";

defineOptions({ layout: FrontLayout });
const form = useForm({
    email: null,
    password: null,
    remember: null,
});
const submit = () => {
    form.post(route("login"), {
        onError: () => form.reset("password", "remember"),
    });
};
</script>

<template>
    <Head title="Login" />
    <div class="text-center m-auto w-2/5 bg-slate-200 p-3">
        <h1 class="text-center">Login to your account</h1>
        <div>
            <form @submit.prevent="submit">
                <Textinput
                    name="email"
                    type="email"
                    v-model="form.email"
                    :message="form.errors.email"
                />
                <Textinput
                    name="password"
                    type="password"
                    v-model="form.password"
                    :message="form.errors.password"
                />
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2">
                        <label for="remember">Remember Me</label>
                        <input
                            type="checkbox"
                            v-model="form.remember"
                            id="remember"
                        />
                    </div>
                </div>
                <div>
                    <button
                        class="bg-blue-400 p-3 rounded"
                        :disabled="form.processing"
                    >
                        Login
                    </button>
                </div>
                <div></div>
            </form>
        </div>
    </div>
</template>
