<script setup>
    import InputError from '@/Components/InputError.vue'
    import Label from '@/Components/Label.vue'
    import Button from '@/Components/Button.vue'
    import Input from '@/Components/Input.vue'
    import { Link, useForm, usePage } from '@inertiajs/inertia-vue3'
    import { onMounted, ref, defineProps } from 'vue'
    import { validateRut, validatePhone } from '@/Utils/validations'
    import { CurrencyDollarIcon, FolderAddIcon, FolderIcon, UserGroupIcon, UserIcon } from '@heroicons/vue/outline'

    const props = defineProps({
        mustVerifyEmail: Boolean,
        status: String,
        companies: Array,
    })

    const isValid = ref(null);
    const isPhoneValid = ref(null);
    const user = usePage().props.value.auth.user
    const isOrdersMode = ref(false); // false = Proyectos, true = Pedidos/Ventas

    const form = useForm({
        name: "",
        email: "",
        rut: "",
        phone: "",
        address: "",
        isOrdersMode: "",
        creation_date: "",
    })

    const CreateCompanyForm = () => {
        form.post(route('company.store'), {
            onSuccess: () => {
                console.log('Formulario enviado correctamente');
            },
            onError: (errors) => {
                console.error('Error en el formulario:', errors);
            },
            onFinish: () => {
                console.log("Proceso de envío de formulario para 'creacion empresas' finalizado.");
            }
        })
    }

    function checkPhone() {
        isPhoneValid.value = validatePhone(form.phone);
    }

    function checkRut() {
        isValid.value = validateRut(form.rut)
    }

    onMounted(() => {
        // console.log("User:", user);
        // console.log("Companies:", props.companies); 
    });
</script>

<template>
        <header class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Mis empresas
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400" v-if="companies[0]">
                    Actualiza la información de tus empresas.
                    <div v-if="user.client.membership" ><p>1 / 1</p></div>
                </p>
                <!-- <div v-if="user.client.membership && !companies[0]" ><p>0 / 1</p></div> -->

            </div>

            <!-- <Button class="px-3 py-2 text-sm font-medium text-white bg-blue-500 rounded hover:bg-blue-600">
                Agregar empresa
            </Button> -->
        </header>


        <div v-for="(company, index) in props.companies" :key="company.id" class="mt-6 space-y-6">
            <div class="w-full max-w-sm p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-6 dark:bg-gray-800 dark:border-gray-700">
                <h5 class="mb-3 text-base font-semibold text-gray-900 md:text-xl dark:text-white">
                    {{ company.name }}
                </h5>
                <p class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Informacion general de la empresa
                </p>
                <ul class="my-4 space-y-3">
                    <li>
                        <a :href="route('dashboard')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                        <CurrencyDollarIcon aria-hidden="true" class="w-5 h-5" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Licitado</span>
                        <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">{{ company.projects.reduce((sum, project) => sum + project.value, 0) }}</span>
                        </a>
                    </li>
                    <li>
                        <a :href="route('proyect.index')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                        <FolderIcon aria-hidden="true" class="w-5 h-5" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Proyectos</span>
                        <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">{{company.projects.length}}</span>
                        </a>
                    </li>
                    <li>
                        <a :href="route('worker.create')" class="flex items-center p-3 text-base font-bold text-gray-900 rounded-lg bg-gray-50 hover:bg-gray-100 group hover:shadow dark:bg-gray-600 dark:hover:bg-gray-500 dark:text-white">
                        <UserGroupIcon aria-hidden="true" class="w-5 h-5" />
                        <span class="flex-1 ms-3 whitespace-nowrap">Trabajadores</span>
                        <span class="inline-flex items-center justify-center px-2 py-0.5 ms-3 text-xs font-medium text-gray-500 bg-gray-200 rounded dark:bg-gray-700 dark:text-gray-400">{{ company.workers.length  }}</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- <form @submit.prevent="submitForm(company.id)" class="space-y-6">
                <div>
                    <Label for="name" value="Nombre" />
                    <Input
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form[company.id].name"
                        required
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form[company.id].errors.name" />
                </div>

                <div>
                    <Label for="email" value="Correo" />
                    <Input
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form[company.id].email"
                        required
                        autocomplete="email"
                    />
                    <InputError class="mt-2" :message="form[company.id].errors.email" />
                </div>

                <div class="flex items-center gap-4">
                    <Button :disabled="form.processing">Guardar</Button>
                    <Transition
                        enter-from-class="opacity-0"
                        leave-to-class="opacity-0"
                        class="transition ease-in-out"
                    >
                        <p
                            v-if="form[company.id].recentlySuccessful"
                            class="text-sm text-gray-600 dark:text-gray-400"
                        >
                            Guardado.
                        </p>
                    </Transition>
                </div>
            </form> -->
        </div>
        <div v-if="!companies[0]">
            <p>Agregar Empresa</p>
            <form class="p-2" @submit.prevent="CreateCompanyForm()">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <Label for="name" value="Nombre" class="text-sm font-semibold text-gray-700" />
                        <Input
                            id="name"
                            type="text"
                            class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
                            v-model="form.name"
                            required
                            autocomplete="name"
                        />
                        <InputError class="mt-1 text-red-500 text-sm" :message="form.errors.name" />
                    </div>

                    <div>
                        <Label for="email" value="Correo" class="text-sm font-semibold text-gray-700" />
                        <Input
                            id="email"
                            type="email"
                            class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
                            v-model="form.email"
                            required
                            autocomplete="email"
                        />
                        <InputError class="mt-1 text-red-500 text-sm" :message="form.errors.email" />
                    </div>

                    <div>
                        <Label for="rut" value="Rut Empresa" />
                        <Input
                            id="rut"
                            type="text"
                            class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
                            v-model="form.rut"
                            required
                            maxlength="10"
                            @input="checkRut"
                            autocomplete="rut"
                        />
                        <InputError class="mt-2 text-red-500 text-sm" :message="form.errors.rut" />
                        <small v-if="isValid === true" class="text-green-600">✅ RUT válido</small>
                        <small v-else-if="isValid === false" class="text-red-600">❌ RUT inválido</small>
                    </div>

                    <div>
                        <Label for="phone" value="Teléfono" />
                        <Input
                            id="rutenterprise"
                            type="text"
                            class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
                            v-model="form.phone"
                            required
                            maxlength="9"
                            @input="checkPhone"
                            autocomplete="phone"
                        />
                        <InputError class="mt-2 text-red-500 text-sm" :message="form.errors.phone" />
                        <small v-if="isPhoneValid === true" class="text-green-600">✅ Número válido</small>
                        <small v-else-if="isPhoneValid === false" class="text-red-600">❌ Número inválido</small>
                    </div>

                    <div>
                        <Label for="address" value="Dirección Empresa" />
                        <Input
                            id="address"
                            type="text"
                            class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
                            v-model="form.address"
                            required
                            autocomplete="address"
                        />
                        <InputError class="mt-2 text-red-500 text-sm" :message="form.errors.address" />
                    </div>

                    <div>
                        <Label for="creation_date" value="Fecha de creación" />
                        <Input
                        id="creation_date"
                        type="date"
                        class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-2 focus:ring-blue-500"
                        v-model="form.creation_date"
                        required
                        autocomplete="creation_date"
                        />
                        <InputError class="mt-2 text-red-500 text-sm" :message="form.errors.creation_date" />
                    </div>
                    
                </div>
                <div class="mt-5">
                    <label for="businessType" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
                    ¿Su empresa gestiona proyectos o pedidos/ventas?
                    </label>
                    <label class="inline-flex items-center cursor-pointer mt-2">
                    <span class="me-3 text-sm font-medium text-gray-900 dark:text-gray-300">Proyectos</span>
                    <input 
                        type="checkbox" 
                        v-model="form.isOrdersMode" 
                        class="sr-only peer"
                    />
                    <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                    </div>
                    <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Pedidos/Ventas</span>
                    </label>
                </div>
                
                <Button class="mt-4">Guardar</Button>
            </form>
        </div>
</template>