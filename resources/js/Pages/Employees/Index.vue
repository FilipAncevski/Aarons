
<script>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3'
export default {
    props: {
        employees: {
            type: Array,
            default: () => [],
        },
    },

    components: {
        AuthenticatedLayout,
        Link
    },

    mounted() {
        //
    }
}
</script>

<template>
    <div>
        <AuthenticatedLayout>
            <div class="max-w-2xl mx-auto">
                <table class="min-w-full bg-white">
                    <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Employee</th>
                        <th class="py-2 px-4 border-b">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="employee in employees" :key="employee.id">
                        <td class="py-2 px-4 border-b text-center">{{ employee.full_name }}</td>
                        <td class="py-2 px-4 border-b">
                            <Link :href="`/employees/${employee.id}`">
                                <button class="bg-blue-500 text-white py-2 px-4 rounded">View</button>
                            </Link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </AuthenticatedLayout>
    </div>
</template>

