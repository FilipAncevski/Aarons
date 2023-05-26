<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import AddShift from '@/components/AddShift.vue';
import UpdateShift from '@/components/UpdateShift.vue';
import { ref, reactive, onMounted, computed } from 'vue';
import axios from 'axios';

const showModal = ref(false);
const selectedShift = ref(null);
const editing = ref(false);

const openModal = () => {
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const handleModelCreated = () => {
    closeModal();
};

const calculateTotalPay = (shift) => {
    return (shift.hours * shift.rate_per_hour).toFixed(2);
};

const editShift = (shift) => {
    selectedShift.value = shift;
    editing.value = true;
};

const closeUpdateModal = () => {
    editing.value = false;
};

const filterTotalPay = ref(null);

const shifts = ref([]);

const pagination = reactive({
    currentPage: 1,
    lastPage: 1,
    total: 0,
});

onMounted(async () => {
    try {
        const response = await axios.get('/api/shifts');
        shifts.value = response.data.data;
        pagination.currentPage = response.data.current_page;
        pagination.lastPage = response.data.last_page;
        pagination.total = response.data.total;
    } catch (error) {
        console.error(error);
    }
});

const goToPage = async (page) => {
    try {
        const response = await axios.get(`/api/shifts?page=${page}`);
        shifts.value = response.data.data;
        pagination.currentPage = response.data.current_page;
        pagination.lastPage = response.data.last_page;
        pagination.total = response.data.total;
    } catch (error) {
        console.error(error);
    }
};

const filteredShifts = computed(() => {
    if (!filterTotalPay.value) {
        return shifts.value;
    }

    const filterValue = parseFloat(filterTotalPay.value);
    return shifts.value.filter((shift) => calculateTotalPay(shift) > filterValue);
});
</script>

<style scoped>
.pagination {
    display: flex;
    justify-content: center;
    align-items: center;
}

.pagination-button {
    padding: 0.5rem;
    margin: 0 0.25rem;
    border-radius: 0.25rem;
}

.pagination-button[disabled] {
    opacity: 0.5;
    cursor: not-allowed;
}

.table-cell {
    width: 150px;
    /* Adjust the width as needed */
    vertical-align: middle;
    text-align: center;
}

.modal {
    position: fixed;
    color: rgb(59 130 246);
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
}
</style>

<template>
    <AuthenticatedLayout>
        <div class="p-4 sm:p-6 lg:p-8">
            <div class="flex justify-between items-center mb-4">
                <button @click="openModal" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                    Create Shift
                </button>
                <input type="number" v-model="filterTotalPay" placeholder="Filter by Total Pay"
                    class="p-2 border border-gray-300 rounded" />
            </div>

            <div class="overflow-x-auto">
                <table class="w-full table-fixed bg-white border border-gray-300">
                    <!-- Table content -->
                    <table class="min-w-full bg-white border border-gray-300">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b">Date</th>
                                <th class="py-2 px-4 border-b">Worker</th>
                                <th class="py-2 px-4 border-b">Company</th>
                                <th class="py-2 px-4 border-b">Hours</th>
                                <th class="py-2 px-4 border-b">Rate per Hour</th>
                                <th class="py-2 px-4 border-b">Taxable</th>
                                <th class="py-2 px-4 border-b">Status</th>
                                <th class="py-2 px-4 border-b">Shift Type</th>
                                <th class="py-2 px-4 border-b">Paid At</th>
                                <th class="py-2 px-4 border-b">Total Pay</th>
                                <th class="py-2 px-4 border-b">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="shift in filteredShifts" :key="shift.id">
                                <td class="py-2 px-4 border-b table-cell">{{ shift.date }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.worker }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.company }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.hours }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.rate_per_hour }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.taxable }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.status }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.shift_type }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ shift.paid_at }}</td>
                                <td class="py-2 px-4 border-b table-cell">{{ calculateTotalPay(shift) }}</td>
                                <td class="py-2 px-4 border-b table-cell">
                                    <Dropdown>
                                        <template #trigger>
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </template>
                                        <template #content>
                                            <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out"
                                                @click="editShift(shift)">
                                                Edit
                                            </button>
                                            <DropdownLink as="button" :href="route('shifts.destroy', shift.id)" method="delete">
                                                Delete
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </table>
            </div>
            <nav class="mt-4 pagination" v-if="pagination.lastPage > 1">
                <button @click="goToPage(1)" :disabled="pagination.currentPage === 1" class="pagination-button">
                    &laquo;
                </button>
                <button @click="goToPage(pagination.currentPage - 1)" :disabled="pagination.currentPage === 1"
                    class="pagination-button">
                    &lt;
                </button>
                <span class="pagination-button">
                    {{ pagination.currentPage }}
                </span>
                <button @click="goToPage(pagination.currentPage + 1)"
                    :disabled="pagination.currentPage === pagination.lastPage" class="pagination-button">
                    &gt;
                </button>
                <button @click="goToPage(pagination.lastPage)" :disabled="pagination.currentPage === pagination.lastPage"
                    class="pagination-button">
                    &raquo;
                </button>
            </nav>
            <AddShift v-if="showModal" @modelCreated="handleModelCreated" @closeModal="closeModal" :closeModal="closeModal"
                class="modal" />
            <div v-if="editing">
                <UpdateShift :shiftData="selectedShift" @closeModal="closeUpdateModal" :closeModal="closeUpdateModal" class="modal"/>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
