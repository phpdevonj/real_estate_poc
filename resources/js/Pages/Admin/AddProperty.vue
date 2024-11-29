<script setup>
import { ref, watch } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../components/TextInput.vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

const { props } = usePage();
const countries = ref(props.countries);
const defaultData = ref(props.defaultData);

const selectedCountry = ref(null);
const states = ref(defaultData.value.states);
const cities = ref(defaultData.value.cities);
const currency = ref(defaultData.value.currency);
const selectedState = ref(null);
const selectedCity = ref(null);

const form = useForm({
    title: null,
    description: null,
    no: null,
    street: null,
    price: null,
    currency: null,
    photos: [],
    size: null,
    unit: null,
    agent: null,
    customer: null,
    country: selectedCountry,
    state: selectedState,
    city: selectedCity,
});

// Watch for changes to update the form
watch(selectedCountry, (value) => {
    form.country = value;
});

watch(selectedState, (value) => {
    form.state = value;
});

watch(selectedCity, (value) => {
    form.city = value;
});
const fetchCountryData = async () => {
    if (selectedCountry.value) {
        try {
            const response = await axios.get(route('getcountrydata', selectedCountry.value));
            states.value = response.data.states;
            cities.value = response.data.cities;
            currency.value = response.data.currency;
        } catch (error) {
            console.error("Error fetching country data:", error);
        }
    } else {
        states.value = [];
        cities.value = [];
        currency.value = null;
    }
};
const fileErrors = ref([]);

// Handle file input validation
const changePhotos = (e) => {
    const files = Array.from(e.target.files);
    fileErrors.value = [];

    if (files.length > 4) {
        fileErrors.value.push("You can upload a maximum of 4 photos.");
    } else {
        const invalidFiles = files.filter((file) => file.size > 3072 * 1024);
        if (invalidFiles.length) {
            fileErrors.value.push("Each photo must not exceed 3 MB.");
        } else {
            form.photos = files;
        }
    }
};

// Submit the form
const submit = () => {
    if (fileErrors.value.length) {
        return; // Prevent submission if there are file errors
    }
    form.post(route("admin.addproperty"), {
        onError: (errors) => {
            console.error(errors);
        },
        onSuccess: () => {
            form.reset();
        },
    });
};

// Reset the form
const cancel = () => {
    form.reset();
};
</script>

<template>
    <Head title=" | Add Property" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">Create Property</h1>
        <form @submit.prevent="submit">
            <TextInput
                name="Title"
                v-model="form.title"
                :message="form.errors.title"
            />

            <div class="flex mr-5 pb-1 mb-2">
                <label for="description" class="w-48">Description</label>
                <textarea
                    id="description"
                    v-model="form.description"
                    class="w-96 border border-gray-300 rounded p-2"
                ></textarea>
                <p class="error mt-2">{{ form.errors.description }}</p>
            </div>

            <TextInput
                name="No"
                v-model="form.no"
                type="number"
                :message="form.errors.no"
            />

            <TextInput
                name="Street"
                v-model="form.street"
                :message="form.errors.street"
            />

            <!-- Country Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="country" class="w-48">Country:</label>
                <select
                    id="country"
                    v-model="selectedCountry"
                    @change="fetchCountryData"
                    class="w-96 border border-gray-300 rounded p-2"
                >
                    <option value="">Select a country</option>
                    <option
                        v-for="(name, id) in countries"
                        :key="id"
                        :value="id"
                    >
                        {{ name }}
                    </option>
                </select>
                <p class="error mt-2">{{ form.errors.country }}</p>
            </div>

            <!-- State Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="state" class="w-48">State:</label>
                <select
                    id="state"
                    v-model="selectedState"
                    class="w-96 border border-gray-300 rounded p-2"
                    :disabled="!selectedCountry"
                >
                    <option value="">Select a state</option>
                    <option
                        v-for="(name, id) in states"
                        :key="id"
                        :value="id"
                    >
                        {{ name }}
                    </option>
                </select>
                <p class="error mt-2">{{ form.errors.state }}</p>
            </div>

            <!-- City Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="city" class="w-48">City:</label>
                <select
                    id="city"
                    v-model="selectedCity"
                    class="w-96 border border-gray-300 rounded p-2"
                    :disabled="!selectedState"
                >
                    <option value="">Select a city</option>
                    <option
                        v-for="(name, id) in cities"
                        :key="id"
                        :value="id"
                    >
                        {{ name }}
                    </option>
                </select>
                <p class="error mt-2">{{ form.errors.city }}</p>
            </div>

            <TextInput
                name="Price"
                v-model="form.price"
                :message="form.errors.price"
            />

            <!-- Currency Display -->
            <div v-if="currency" class="flex mr-5 pb-1 mb-2">
                <label class="w-48">Currency:</label>
                <div class="w-96 p-2 bg-gray-50 border border-gray-200 rounded">
                    {{ currency.currency_name }} ({{ currency.currency_symbol }})
                </div>
            </div>

            <div class="flex mr-5 pb-1 mb-2">
                <label for="photos" class="w-48">Photos</label>
                <input
                    type="file"
                    id="photos"
                    multiple
                    @change="changePhotos"
                />
                <p v-if="fileErrors.length" class="text-red-500 mt-2">
                    {{ fileErrors.join(", ") }}
                </p>
                <p class="error mt-2">{{ form.errors.photos }}</p>
            </div>

            <TextInput
                name="Size"
                v-model="form.size"
                :message="form.errors.size"
            />

            <div class="flex mr-5 pb-1 mb-2">
                <label for="unit" class="w-48">Measuring Unit</label>
                <select id="unit" v-model="form.unit" class="w-96">
                    <option
                        v-for="(value, key) in unitOptions"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
                <p class="error mt-2">{{ form.errors.unit }}</p>
            </div>

            <div class="flex mr-5 pb-1 mb-2">
                <label for="agent" class="w-48">Agent</label>
                <select id="agent" v-model="form.agent" class="w-96">
                    <option
                        v-for="(value, key) in agentOptions"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
                <p class="error mt-2">{{ form.errors.agent }}</p>
            </div>

            <TextInput
                name="Customer"
                v-model="form.customer"
                :message="form.errors.customer"
            />

            <div class="flex mr-5 pb-1 mb-2 justify-between mt-4">
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
