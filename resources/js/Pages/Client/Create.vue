<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { UserIcon, MailIcon, LockClosedIcon, UserAddIcon, IdentificationIcon, LocationMarkerIcon, PhoneIcon } from '@heroicons/vue/outline'
import GuestLayout from '@/Layouts/Guest.vue'
import InputIconWrapper from '@/Components/InputIconWrapper.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import Button from '@/Components/Button.vue'
import { defineProps, ref } from 'vue';
import { validateRut,validatePhone } from '@/Utils/validations'
const props = defineProps({
  user: Object,
});
const isValid = ref(null);
const isPhoneValid = ref(null);

const form = useForm({
    name: props.user?.name || '',
    email: props.user?.email || '',
    rut: '',
    address: '',
    phone: '',
})

const submit = () => {
    if (isValid.value && isPhoneValid.value) {
        form.post(route('client.store'), {
            onSuccess: () => {
                console.log("¡Cliente creado con éxito!");
            },
            onError: (errors) => {
                alert("Ha ocurrido un error al crear el cliente. Por favor, revisa los campos.");
                console.error("Errores del servidor:", errors);
            },
            onFinish: () => {
                console.log("Proceso de envío de formulario para 'cliente' finalizado.");
            }
        });
    } else {
        alert("Falta completar campos importantes o la información no es válida.");
    }
};

function checkPhone() {
    isPhoneValid.value = validatePhone(form.phone);
}

function checkRut() {
  isValid.value = validateRut(form.rut)
}
</script>

<template>
    <GuestLayout title="Register">
        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="grid gap-6 p-2">
                <div class="space-y-2">
                    <Label for="name" value="Nombre Completo" />
                    <InputIconWrapper>
                        <template #icon>
                            <UserIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="name" type="text" placeholder="Nombre Completo" class="block w-full" v-model="form.name" required autocomplete="name" />
                    </InputIconWrapper>
                </div>
                
                <div class="space-y-2">
                    <Label for="email" value="Correo electronico" />
                    <InputIconWrapper>
                        <template #icon>
                            <MailIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="email" type="email" class="block w-full" placeholder="Correo electronico" v-model="form.email" required autocomplete="username" />
                    </InputIconWrapper>
                </div>

                <div class="space-y-2">
                    <Label for="rut" value="Rut (Con guion sin puntos)" />
                    <InputIconWrapper>
                        <template #icon>
                            <IdentificationIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="rut" type="text" placeholder="99999999-9" @input="checkRut" maxlength="10" class="block w-full" v-model="form.rut" required autocomplete="rut" />
                    </InputIconWrapper>
                    <small v-if="isValid === true">✅ RUT válido</small>
                    <small v-else-if="isValid === false">❌ RUT inválido</small>
                </div>

                <div class="space-y-2">
                    <Label for="address" value="Dirección" />
                    <InputIconWrapper>
                        <template #icon>
                            <LocationMarkerIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="address" type="text" placeholder="Direccion" class="block w-full" v-model="form.address" required autocomplete="address" />
                    </InputIconWrapper>
                </div>

                <div class="space-y-2">
                    <Label for="phone" value="Teléfono" />
                    <InputIconWrapper>
                        <template #icon>
                            <PhoneIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="phone" type="text" @input="checkPhone" maxlength="9" placeholder="9 9999 9999" class="block w-full" v-model="form.phone" required autocomplete="phone" />
                    </InputIconWrapper>
                    <small v-if="isPhoneValid === true" class="text-green-600">✅ Número válido</small>
                    <small v-else-if="isPhoneValid === false" class="text-red-600">❌ Número inválido</small>
                </div>

                <div>
                    <Button class="justify-center gap-2 w-full" :disabled="form.processing" v-slot="{ iconSizeClasses }">
                        <UserAddIcon aria-hidden="true" :class="iconSizeClasses" />
                        <span>Continuar registro</span>
                    </Button>
                </div>

                <p class="text-sm text-gray-600 dark:text-gray-400">
                    ¿Ya tienes una cuenta?
                    <Link :href="route('login')" class="text-blue-500 hover:underline">
                        Ingresar
                    </Link>
                </p>
            </div>

        </form>
    </GuestLayout>
</template>
