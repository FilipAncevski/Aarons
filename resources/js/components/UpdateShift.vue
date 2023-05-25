<template>
    <div class="bg-white p-6 rounded flex flex-col">
        <h1 class="text-lg font-semibold mb-4">Update Shift</h1>
        <form @submit.prevent="handleUpdate" class="space-y-4">
            <div class="flex flex-col">
                <label for="date" class="mb-1">Date:</label>
                <input type="date" id="date" v-model="shift.date" required class="border border-gray-300 p-2 rounded">
            </div>
            <div class="flex flex-col">
                <label for="worker" class="mb-1">Worker:</label>
                <input type="text" id="worker" v-model="shift.worker" required class="border border-gray-300 p-2 rounded">
            </div>
            <div class="flex flex-col">
                <label for="company" class="mb-1">Company:</label>
                <input type="text" id="company" v-model="shift.company" required class="border border-gray-300 p-2 rounded">
            </div>
            <div class="flex flex-col">
                <label for="hours" class="mb-1">Hours:</label>
                <input type="number" step="any" id="hours" v-model="shift.hours" required class="border border-gray-300 p-2 rounded">
            </div>
            <div class="flex flex-col">
                <label for="ratePerHour" class="mb-1">Rate per Hour:</label>
                <input type="number" step="any" id="ratePerHour" v-model="shift.rate_per_hour" required
                    class="border border-gray-300 p-2 rounded">
            </div>
            <div class="flex items-center">
                <input type="checkbox" id="taxable" v-model="shift.taxable" class="mr-2">
                <label for="taxable" class="mb-1">Taxable:</label>
            </div>
            <div class="flex flex-col">
                <label for="status" class="mb-1">Status:</label>
                <select id="status" v-model="shift.status" required class="border border-gray-300 p-2 rounded">
                    <option value="Pending">Pending</option>
                    <option value="Completed">Completed</option>
                    <option value="Failed">Failed</option>
                </select>
            </div>
            <div class="flex flex-col">
                <label for="shiftType" class="mb-1">Shift Type:</label>
                <select id="shiftType" v-model="shift.shift_type" required class="border border-gray-300 p-2 rounded">
                    <option value="Day">Day</option>
                    <option value="Night">Night</option>
                    <option value="Holiday">Holiday</option>
                </select>
            </div>
            <div class="flex flex-col">
      <label for="paidAt" class="mb-1">Paid At:</label>
      <input
        type="date"
        id="paidAt"
        :value="shift.paid_at || null"
        @input="shift.paid_at = $event.target.value || null"
        class="border border-gray-300 p-2 rounded"
      >
    </div>
            <div class="flex justify-between">
                <button type="submit"
                    class="bg-blue-900 hover:bg-blue-600 text-whitefont-semibold py-2 px-4 rounded">Submit</button>
                <button type="button" @click="$emit('closeModal')"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Close</button>
            </div>
        </form>
        <!-- <div v-if="successMessage.value" class="mt-4 p-2 bg-green-200 text-green-800 rounded">
            {{ successMessage.value }}
        </div>
        <div v-if="errorMessage.value" class="mt-4 p-2 bg-red-200 text-red-800 rounded">
            {{ errorMessage.value }}
        </div> -->
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default {
    props: {
        closeModal: Function,
        shiftData: Object,
    },

    setup(props) {
        const shift = reactive(props.shiftData);
        const successMessage = ref(null);
        const errorMessage = ref(null);


        const handleUpdate = async () => {
            try {
                const form = useForm(shift);
                const response = await form.put(`/shifts/${shift.id}`, shift);
                props.closeModal();
                if (response && response.data.success) {
                    successMessage.value = 'Shift updated successfully.';
                } else {
                    errorMessage.value = 'Failed to update shift.';
                }
            } catch (error) {
                console.error(error);
                errorMessage.value = 'An error occurred while updating the shift.';
            }
        };


        return {
            shift,
            successMessage,
            errorMessage,
            handleUpdate,
        };
    },
};
</script>
