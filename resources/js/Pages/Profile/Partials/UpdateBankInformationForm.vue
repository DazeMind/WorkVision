<script setup>
import InputError from '@/Components/InputError.vue'
import Label from '@/Components/Label.vue'
import Button from '@/Components/Button.vue'
import Input from '@/Components/Input.vue'
import {useForm, usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
    banks: Array,
    typesAccount: Array,
})

const user = usePage().props.value.auth?.user;
const client = user?.client;

const form = useForm({
    id_client: client?.id || '',
    id_bank: client?.bank_data[0]?.id_bank || '',
    id_bank_account_type: client?.bank_data[0]?.id_bank_account_type || '',
    account_number: client?.bank_data[0]?.account_number || '',
})

const CreateBankDataForm = () => {
    form.post(route('BankData.store'), {
        onSuccess: () => {
            console.log("éxito");
        },
        onError: () => {
            console.log("error");
        }
    });
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Datos bancarios
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Actualiza tu informacion personal
            </p>
        </header>

        <form @submit.prevent="CreateBankDataForm()" class="mt-6 space-y-6">
            <div class="grid grid-cols-1  lg:grid-cols-2 gap-4">
                <div>
                    <label for="bank" class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-2">
                        Selecciona un Banco
                    </label>
                    <select v-model="form.id_bank" class="w-full border p-2 rounded-xl dark:text-gray-400">
                        <option value="" disabled selected>Selecciona Banco</option>
                        <option v-for="bank in banks" :key="bank.id" :value="bank.id">
                            {{ bank.name }}
                        </option>
                    </select>
                </div>

                <div>
                    <label for="bank" class="block text-gray-700 text-sm font-bold mb-2 dark:text-gray-400">
                        Selecciona tipo de cuenta
                    </label>
                    <select v-model="form.id_bank_account_type" class="w-full border p-2 rounded-xl dark:text-gray-400">
                        <option value="" disabled selected>Selecciona tipo de cuenta</option>
                        <option v-for="typeAccount in typesAccount" :key="typeAccount.id" :value="typeAccount.id">
                            {{ typeAccount.name }}
                        </option>
                    </select>
                </div>

                <div class="dark:text-gray-400">
                    <Label for="account_number" value="Número de cuenta" />
                    <Input
                        id="account_number"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.account_number"
                        required
                        autocomplete="account_number"
                        placeholder="11111111..."
                    />
                    <InputError class="mt-2" :message="form.errors.account_number" />
                </div>
            </div>

            <div class="flex items-center gap-4 justify-bottom">
                <Button :disabled="form.processing">Guardar</Button>

                <Transition
                    enter-from-class="opacity-0"
                    leave-to-class="opacity-0"
                    class="transition ease-in-out"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">
                        Actualizado.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
