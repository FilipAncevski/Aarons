
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
export default {
    props: {
        employee: {
            type: Object,
            default: () => {},
        },
        shifts: {
            type: Array,
            default: () => [],
        }
    },

    components: {
        AuthenticatedLayout,
    },

    mounted() {
        //
    }
}
</script>

<template>
    <AuthenticatedLayout>
    <div>
        <div class="max-w-2xl mx-auto">
            <p class="py-4 bg-green-200 rounded-lg px-4">Full Name: {{ employee.full_name }}</p>
            <p class="py-4 bg-green-200 rounded-lg px-4">Average Pay Per Hour: £ {{ employee.average_pay_per_hour }}</p>
            <p class="py-4 bg-green-200 rounded-lg px-4">Average Total Pay: £ {{ employee.average_total_pay }}</p>
        </div>

        <div class="max-w-2xl mx-auto">
            <table class="min-w-full bg-white">
                <caption class="text-lg font-semibold text-center py-4 my-4">Last Five Completed Payments</caption>
                <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Date</th>
                    <th class="py-2 px-4 border-b">Amount</th>
                    <th class="py-2 px-4 border-b">Taxable</th>
                    <th class="py-2 px-4 border-b">Shift Type</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="payment in shifts" :key="payment.id">
                    <td class="py-2 px-4 border-b text-center">{{ payment.date }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ payment.hours * payment.rate_per_hour }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ payment.taxable ? 'Yes' : 'No' }}</td>
                    <td class="py-2 px-4 border-b text-center">{{ payment.shift_type }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    </AuthenticatedLayout>
</template>

