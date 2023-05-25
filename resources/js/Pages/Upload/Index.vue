<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { ref } from 'vue';
import axios from 'axios';

const successMessage = ref('');
const errorMessage = ref('');

const submitForm = () => {
    const fileInput = document.getElementById('csv_file');
    const file = fileInput.files[0];

    const formData = new FormData();
    formData.append('csv_file', file);

    axios
        .post('/upload', formData)
        .then((response) => {
            successMessage.value = response.data.message;
            errorMessage.value = '';
        })
        .catch((error) => {
            if (error.response && error.response.data && error.response.data.message) {
                errorMessage.value = error.response.data.message;
            } else {
                errorMessage.value = 'An error occurred while uploading the file.';
            }
            successMessage.value = '';
        });
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="container mx-auto p-4">
            <form @submit.prevent="submitForm">
                <div class="mb-4">
                    <label for="csv_file" class="block font-bold mb-2">Upload CSV File</label>
                    <input id="csv_file" type="file" class="border border-gray-300 px-4 py-2 w-full" required />
                </div>

                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Submit
                </button>
            </form>

            <div v-if="successMessage" class="mt-4 p-2 bg-green-200 text-green-800 rounded">
                {{ successMessage }}
            </div>

            <div v-if="errorMessage" class="mt-4 p-2 bg-red-200 text-red-800 rounded">
                {{ errorMessage }}
            </div>
        </div>
    </AuthenticatedLayout>
</template>
