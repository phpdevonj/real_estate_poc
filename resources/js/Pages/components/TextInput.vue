<script setup>
const model = defineModel({
    type: null,
    required: true,
});

defineProps({
    name: {
        type: String,
        required: true, // Ensure the prop is truly required
    },
    type: {
        type: String,
        default: "text", // Default input type
    },
    message: String, // Validation error message
});
</script>

<template>
    <div class="mb-6 w-full">
        <label class="block text-left">{{ name }}</label>
        <!-- Pass all remaining attributes -->
        <input
            :type="type"
            v-bind="$attrs"
            v-model="model"
            :class="{ '!text-red-500': message }"
            class="border-solid border-2 rounded w-full"
        />
        <small class="text-red-500" v-if="message">{{ message }}</small>
    </div>
</template>
