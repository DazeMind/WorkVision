<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue'
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue'
import DeleteUserForm from './Partials/DeleteUserForm.vue'
import UpdateCompaniesInformation from './Partials/UpdateCompaniesInformation.vue';
import UpdateBankInformationForm from './Partials/UpdateBankInformationForm.vue';
import { onMounted, defineProps } from 'vue'

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    companies: Array,
    banks: Array,
    typesAccount: Array,
})

onMounted(() => {
//   console.log("typesAccount:", user);
});
</script>

<template>
    <AuthenticatedLayout title="Profile">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" >
                Mis Datos
            </h2>
        </template>
        <div class="flex flex-col lg:flex-row gap-4">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg w-full">
                <UpdateCompaniesInformation
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    :companies="companies"
                />
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg w-full">
                <UpdateBankInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    :banks="banks"
                    :typesAccount="typesAccount"
                />
            </div>
        </div>

        <div class="space-y-6">

            <!-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div> -->

            <!-- <div
                class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg"
            >
                <UpdatePasswordForm class="max-w-xl" />
            </div> -->
            
            <!-- <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg" >
                <DeleteUserForm class="max-w-xl" />
            </div> -->
        </div>
    </AuthenticatedLayout>
</template>
