<template>
    <Head :title="' | Customers List'" />
    <div class="m-auto bg-slate-200 p-3">
        <h1 class="text-center">View Customers List</h1>
        <div class="">
            <div class="flex justify-end mb-4">
                <div class="w-full max-w-md">
                    <!-- Adjust width and max-width for better control -->
                    <!-- <input
                        type=""
                        placeholder=""
                        v-model=""
                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    /> -->
                </div>
            </div>
            <table class="w-3/4 mx-auto p-2">
                <thead>
                    <tr class="bg-slate-300">
                        <th class="text-left p-2">Name</th>
                        <th class="text-left p-2">Address</th>
                        <th class="text-left p-2">Mobile</th>
                        <th class="text-left p-2">Email</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</template>
