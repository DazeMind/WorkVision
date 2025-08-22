<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3'
import { UserIcon, MailIcon, LockClosedIcon, UserAddIcon, IdentificationIcon } from '@heroicons/vue/outline'
import GuestLayout from '@/Layouts/Guest.vue'
import InputIconWrapper from '@/Components/InputIconWrapper.vue'
import Input from '@/Components/Input.vue'
import Label from '@/Components/Label.vue'
import ValidationErrors from '@/Components/ValidationErrors.vue'
import Button from '@/Components/Button.vue'

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
})

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    })
}
</script>

<template>
    <GuestLayout title="Register">
        <ValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
            <h3 class="text-2xl text-bold text-center my-4">Regístrate</h3>

            <div class="grid gap-6">
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
                    <Label for="password" value="Contraseña" />
                    <InputIconWrapper>
                        <template #icon>
                            <LockClosedIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="password" type="password" class="block w-full" placeholder="Contraseña" v-model="form.password" required autocomplete="new-password" />
                    </InputIconWrapper>
                </div>

                <div class="space-y-2">
                    <Label for="password_confirmation" value="Confirmar contraseña" />
                    <InputIconWrapper>
                        <template #icon>
                            <LockClosedIcon aria-hidden="true" class="w-5 h-5" />
                        </template>
                        <Input withIcon id="password_confirmation" type="password" class="block w-full" placeholder="Confirmar contraseña" v-model="form.password_confirmation" required autocomplete="new-password" />
                    </InputIconWrapper>
                </div>

                <div>
                    <Button class="justify-center gap-2 w-full" :disabled="form.processing" v-slot="{ iconSizeClasses }">
                        <UserAddIcon aria-hidden="true" :class="iconSizeClasses" />
                        <span>Registrate gratis</span>
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
