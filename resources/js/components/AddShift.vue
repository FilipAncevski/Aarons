<template>
    <div class="bg-white p-6 rounded flex flex-col">
      <h1 class="text-lg font-semibold mb-4">Add Shift</h1>
      <form @submit.prevent="handleSubmit" class="space-y-4">
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
          <input type="number" id="hours" v-model="shift.hours" required class="border border-gray-300 p-2 rounded">
        </div>
        <div class="flex flex-col">
          <label for="ratePerHour" class="mb-1">Rate per Hour:</label>
          <input type="number" id="ratePerHour" v-model="shift.rate_per_hour" required class="border border-gray-300 p-2 rounded">
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
          <input type="date" id="paidAt" v-model="shift.paid_at" required class="border border-gray-300 p-2 rounded">
        </div>
        <div class="flex justify-between">
          <button type="submit" class="bg-blue-900 hover:bg-blue-600 text-whitefont-semibold py-2 px-4 rounded">Submit</button>
          <button type="button" @click="$emit('closeModal')" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">Close</button>
        </div>
      </form>
      <div v-if="successMessage.value" class="mt-4 p-2 bg-green-200 text-green-800 rounded">
      {{ successMessage.value }}
    </div>
    <div v-if="errorMessage.value" class="mt-4 p-2 bg-red-200 text-red-800 rounded">
      {{ errorMessage.value }}
    </div>
    </div>
  </template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';

export default {
  props: {
    closeModal: Function
  },

    setup(props) {
        const shift = useForm({
            date: '',
            worker: '',
            company: '',
            hours: '',
            rate_per_hour: '',
            taxable: false,
            status: '',
            shift_type: '',
            paid_at: '',
        });

    const successMessage = ref('');
    const errorMessage = ref('');

    const handleSubmit = async () => {
      try {
        const response = await shift.post(route('shifts.store'), {
          onSuccess: () => {
            shift.reset();
            props.closeModal(); // Close the modal by calling the prop method
          },
        });

        if (response && response.success) {
          successMessage.value = 'Shift created successfully.'; // Set the success message
          errorMessage.value = ''; // Reset the error message
        } else {
          successMessage.value = ''; // Reset the success message
          errorMessage.value = 'Failed to create shift. Please try again.'; // Set the error message
        }
      } catch (error) {
        console.error(error);
        successMessage.value = ''; // Reset the success message
        errorMessage.value = 'An error occurred. Please try again.'; // Set the error message
      }
    };

    return {
      shift,
      successMessage,
      errorMessage,
      handleSubmit,
    };
  },
};
</script>


