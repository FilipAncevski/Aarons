
<script>
export default {
  props: {
    employees: {
      type: Array,
      default: () => [],
    },
  },

}
</script>

<template>
    <div>
      <ul>
        <li v-for="employee in employees" :key="employee.id">
          {{ employee.full_name }}
        </li>
      </ul>
    </div>
  </template>




<!-- <template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Employee
                    v-for="employee in employees"
                    :key="employee.id"
                    :employee="employee"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template> -->
<!-- import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Employee from '@/Components/Employee.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3'; -->
