<script setup>
import { ref, watch, onMounted, computed } from "vue";
import { useForm } from "@inertiajs/vue3";
import TextInput from "../components/TextInput.vue";
import { usePage } from "@inertiajs/vue3";
import axios from "axios";

const { props } = usePage();
const countries = ref(props.countries);
const defaultData = ref(props.defaultData);
const property = ref(props.property);

const selectedCountry = ref(property.value.country);
const states = ref("");
const cities = ref("");
const currency = ref(defaultData.value.currency);
const selectedState = ref(property.value.state);
const selectedCity = ref(property.value.city);
const customerOptions = ref(props.customerOptions);
const agentOptions = ref(props.agentOptions);
const propertySizeUnits = ref(props.propertySizeUnits);
const previewUrls = ref([]); // For new photos
const DEFAULT_IMAGE = "/storage/property_photos/noproperty.png"; // Update this path to your default image
const MAX_PHOTOS = 4;

const existingPhotos = ref(
    property.value.photos_url && property.value.photos_url.length > 0
        ? property.value.photos_url
        : [DEFAULT_IMAGE]
);
// Compute remaining photo slots
const remainingPhotoSlots = computed(() => {
    return MAX_PHOTOS - existingPhotos.value.length;
});
// Initialize form with existing property data
const form = useForm({
    title: property.value.title,
    description: property.value.description,
    no: property.value.no,
    street: property.value.street,
    price: property.value.price,
    currency: property.value.currency,
    photos: [],
    size: property.value.size,
    unit: property.value.unit,
    agent: property.value.agent_id,
    customer: property.value.customer_id,
    country: property.value.country,
    state: property.value.state,
    city: property.value.city,
    photos: [],
    removed_photos: [], // Track removed photos
    _method: "PUT",
});
// Load initial data
onMounted(async () => {
    if (selectedCountry.value) {
        await fetchCountryData();
    }
    if (selectedState.value) {
        await fetchCities();
    }
});
// Watch for changes to update the form
watch(selectedCountry, (value) => {
    form.country = value;
});

watch(selectedState, (value) => {
    if (!value) {
        selectedCity.value = "";
        form.city = "";
    }
    form.state = value || "";
});

watch(selectedCity, (value) => {
    form.city = value;
});
// Fetch functions
const fetchCities = async () => {
    if (selectedState.value) {
        try {
            const response = await axios.get(
                route("getstatecities", selectedState.value)
            );
            cities.value = response.data.cities;
        } catch (error) {
            console.error("Error fetching cities:", error);
        }
    } else {
        cities.value = [];
        selectedCity.value = "";
        form.city = "";
    }
};

const fetchCountryData = async () => {
    if (selectedCountry.value) {
        try {
            const response = await axios.get(
                route("getcountrydata", selectedCountry.value)
            );
            states.value = response.data.states;
            currency.value = response.data.currency;
        } catch (error) {
            console.error("Error fetching country data:", error);
        }
    } else {
        states.value = [];
        cities.value = [];
        currency.value = null;
        selectedState.value = "";
        selectedCity.value = "";
        form.state = "";
        form.city = "";
    }
};
const fileErrors = ref([]);
// Handle file input validation
const changePhotos = (e) => {
    const files = Array.from(e.target.files);
    fileErrors.value = [];
    // Check if we have space for new photos
    if (files.length > remainingPhotoSlots.value) {
        fileErrors.value.push(
            `You can only add ${remainingPhotoSlots.value} more photo(s)`
        );
        e.target.value = "";
        return;
    }
    const invalidFiles = files.filter((file) => file.size > 3072 * 1024);
    if (invalidFiles.length) {
        fileErrors.value.push("Each photo must not exceed 3MB");
        e.target.value = "";
        return;
    }

    form.photos = files;
    previewUrls.value = files.map((file) => URL.createObjectURL(file));
};
// Remove existing photo
const removePhoto = (index) => {
    if (confirm("Are you sure you want to remove this photo?")) {
        form.removed_photos.push(existingPhotos.value[index]);
        existingPhotos.value.splice(index, 1);
    }
};
// Submit the form
const submit = () => {
    if (fileErrors.value.length) {
        return;
    }
    form.post(route("admin.updateproperty", property.value.id), {
        onError: (errors) => {
            console.error(errors);
        },
        preserveScroll: true,
    });
};
// Cancel edit
const cancel = () => {
    window.location = route("admin.viewproperty");
};
// Function to clean photo URLs
const getPhotoUrl = (photo) => {
    // Remove any duplicate /storage/ prefixes
    return photo.replace("/storage/", "");
};
</script>
<style scoped>
.group:hover .group-hover\:opacity-100 {
    opacity: 1;
}
</style>

<template>
    <Head title=" | Edit Property" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">Edit Property</h1>
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
                type="text"
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
                    class="w-96 border border-gray-300 rounded p-2"
                    disabled
                    title="Location cannot be changed after property creation"
                >
                    <option
                        v-for="(name, id) in countries"
                        :key="id"
                        :value="id"
                    >
                        {{ name }}
                    </option>
                </select>
                <span class="text-sm text-gray-500 ml-2">
                    Location cannot be changed. Create new property for
                    different location.
                </span>
            </div>
            <!-- State Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="state" class="w-48">State:</label>
                <select
                    id="state"
                    v-model="selectedState"
                    class="w-96 border border-gray-300 rounded p-2"
                    disabled
                >
                    <option v-for="(name, id) in states" :key="id" :value="id">
                        {{ name }}
                    </option>
                </select>
            </div>
            <!-- City Dropdown -->
            <div class="flex mr-5 pb-1 mb-2">
                <label for="city" class="w-48">City:</label>
                <select
                    id="city"
                    v-model="selectedCity"
                    class="w-96 border border-gray-300 rounded p-2"
                    disabled
                >
                    <option v-for="(name, id) in cities" :key="id" :value="id">
                        {{ name }}
                    </option>
                </select>
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
                    {{ currency.currency_symbol }}
                </div>
            </div>

            <div class="flex mr-5 pb-1 mb-2 flex-col">
                <label class="w-48 mb-2">Property Images</label>
                <!-- Image Gallery -->
                <div class="bg-white p-4 rounded-lg shadow mb-4">
                    <!-- Show default image if no images exist -->
                    <div
                        v-if="!existingPhotos.length && !previewUrls.length"
                        class="mb-4"
                    >
                        <div class="grid grid-cols-1 gap-4">
                            <div class="relative">
                                <img
                                    :src="DEFAULT_IMAGE"
                                    class="w-full h-48 object-cover rounded-lg border-2 border-gray-200"
                                />
                                <span
                                    class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm"
                                >
                                    Default Image
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Existing Photos -->
                    <div v-if="existingPhotos.length" class="mb-4">
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="(photo, index) in existingPhotos"
                                :key="index"
                                class="relative group"
                            >
                                <img
                                    :src="photo"
                                    class="w-full h-48 object-cover rounded-lg border-2 border-gray-200"
                                />
                                <button
                                    type="button"
                                    @click="removePhoto(index)"
                                    class="absolute top-2 right-2 bg-red-500 text-white rounded-full w-8 h-8 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-200"
                                >
                                    ×
                                </button>
                                <span
                                    class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm"
                                >
                                    Image {{ index + 1 }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Preview New Photos -->
                    <div v-if="previewUrls.length" class="mt-4">
                        <h4 class="text-sm font-medium mb-2">
                            New Photos Preview:
                        </h4>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div
                                v-for="(url, index) in previewUrls"
                                :key="index"
                                class="relative group"
                            >
                                <img
                                    :src="url"
                                    class="w-full h-48 object-cover rounded-lg border-2 border-blue-200"
                                />
                                <span
                                    class="absolute bottom-2 left-2 bg-black bg-opacity-50 text-white px-2 py-1 rounded text-sm"
                                >
                                    New Image {{ index + 1 }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- Upload New Photos Section -->
                    <div
                        v-if="remainingPhotoSlots > 0"
                        class="border-t pt-4 mt-4"
                    >
                        <div class="flex items-center space-x-4">
                            <label
                                for="photos"
                                class="cursor-pointer bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition-colors"
                            >
                                Add {{ remainingPhotoSlots }} More Photo{{
                                    remainingPhotoSlots > 1 ? "s" : ""
                                }}
                            </label>
                            <input
                                type="file"
                                id="photos"
                                multiple
                                @change="changePhotos"
                                accept="image/*"
                                class="hidden"
                                :max="remainingPhotoSlots"
                            />
                            <span class="text-sm text-gray-500">
                                You can add up to {{ remainingPhotoSlots }} more
                                photo(s), each under 3MB
                            </span>
                        </div>

                        <!-- Error Messages -->
                        <div v-if="fileErrors.length" class="mt-2">
                            <p
                                v-for="(error, index) in fileErrors"
                                :key="index"
                                class="text-red-500 text-sm"
                            >
                                {{ error }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <TextInput
                name="Size"
                v-model="form.size"
                :message="form.errors.size"
            />

            <div class="flex mr-5 pb-1 mb-2">
                <label for="unit" class="w-48">Measuring Unit</label>
                <select id="unit" v-model="form.unit" class="w-96">
                    <option value="">Select a unit</option>
                    <option
                        v-for="(value, key) in propertySizeUnits"
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
                    <option value="">Select an agent</option>
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

            <div class="flex mr-5 pb-1 mb-2">
                <label for="customer" class="w-48">Customer</label>
                <select id="customer" v-model="form.customer" class="w-96">
                    <option value="">Select a customer</option>
                    <option
                        v-for="(value, key) in customerOptions"
                        :key="key"
                        :value="key"
                    >
                        {{ value }}
                    </option>
                </select>
                <p class="error mt-2">{{ form.errors.customer }}</p>
            </div>

            <div class="flex mr-5 pb-1 mb-2 justify-between mt-4">
                <button
                    class="bg-blue-400 p-3 rounded"
                    :disabled="form.processing"
                >
                    Update
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
