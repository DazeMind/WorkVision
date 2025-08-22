<script setup>
    import Button from '@/Components/Button.vue'
    import Input from '@/Components/Input.vue';
    import SelectAFP from './SelectAFP.vue';
    import { validateRut, validatePhone } from '@/Utils/validations'
    import CompanySelect from '@/Components/Selects/CompanySelect.vue';
    import { useForm } from '@inertiajs/inertia-vue3'
    import { ref } from 'vue';
    import ValidationErrors from '@/Components/ValidationErrors.vue';
    //Props
    const props = defineProps({
      clients: Object,
      companies: Object,
      worker: {
        type: Object,
        required: false,
        default: () => ({})
      }    
    });
    //Data
    const formData = useForm({
      first_name: props.worker.first_name || "",
      second_name: props.worker.second_name || "",
      first_last_name: props.worker.first_last_name || "",
      second_last_name: props.worker.second_last_name || "",
      rut: props.worker.rut || "",
      email: props.worker.email || "",
      phone: props.worker.phone || "",
      address: props.worker.address || "",
      dob: props.worker.date_of_birth || "",
      afp: props.worker.afp || "",
      health_plan: props.worker.health_plan || "",
      id_company: props.worker.id_company || "",
      date: new Date().toISOString().slice(0, 10), // Establecer la fecha actual
    })

    const isValidRut = ref(null);
    const isPhoneValid = ref(null);
    const emit = defineEmits(['closeModalCreate']);

    //methods
    const checkPhone = () => {
      isPhoneValid.value = validatePhone(formData.phone);
    };
    const checkRut = () => {
      isValidRut.value = validateRut(formData.rut); // ✅ Correcto

    };

    const sendForm = () => {
      checkRut();
      checkPhone();
      if (isValidRut.value && isPhoneValid.value) {
          formData.post(route('worker.store'), {
              onSuccess: () => {
                console.log("¡Cliente creado con éxito!");
                emit('closeModalCreate');
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

  </script>


<template>
  <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <h2 class="text-xl font-semibold leading-tight"> Crear colaborador </h2>
  </div>

  <ValidationErrors class="mb-4" />
  <form @submit.prevent="sendForm" class="grid gap-6 max-w-4xl mx-auto mt-8">

    <!-- Empresa -->
    <div class="col-span-6" v-if="worker && Object.keys(worker).length <= 0">
      <CompanySelect
        v-model="formData.id_company"
        :options="companies"
        label="Selecciona la empresa"
        input-id="id_company"
        :required="true"
      />
    </div>
    <!-- Primer Nombre -->
    <div class="col-span-6">
      <label for="first_name" class="block text-gray-700 text-sm font-bold mb-2">Primer Nombre</label>
      <Input type="text" v-model="formData.first_name" class="w-full border p-2 rounded-xl" :isRequired="true" minlength="3" placeholder="Primer Nombre" />
    </div>
    <!-- Segundo Nombre -->
    <div class="col-span-6">
      <label for="second_name" class="block text-gray-700 text-sm font-bold mb-2">Segundo Nombre</label>
      <Input type="text" v-model="formData.second_name" class="w-full border p-2 rounded-xl" :isRequired="true" minlength="3" placeholder="Segundo Nombre" />
    </div>
    <!-- Apellido Paterno -->
    <div class="col-span-6">
      <label for="first_last_name" class="block text-gray-700 text-sm font-bold mb-2">Apellido Paterno</label>
      <Input type="text" v-model="formData.first_last_name" class="w-full border p-2 rounded-xl" :isRequired="true" minlength="3" placeholder="Apellido Paterno" />
    </div>

    <!-- Apellido Materno -->
    <div class="col-span-6">
      <label for="second_last_name" class="block text-gray-700 text-sm font-bold mb-2">Apellido Materno</label>
      <Input type="text" v-model="formData.second_last_name" class="w-full border p-2 rounded-xl" :isRequired="true" minlength="3" placeholder="Apellido Materno"/>
    </div>

    <!-- Rut -->
    <div class="col-span-6">
      <label for="rut" class="block text-gray-700 text-sm font-bold mb-2">Rut</label>
      <Input
        id="rut"
        :maxlength="10"
        :minlength="9"
        @input="checkRut"
        v-model="formData.rut"
        type="text"
        class="w-full border p-2 rounded-xl"
        placeholder="Ingrese Rut"
        :isRequired="true"
      />
      <!-- <InputError class="mt-2 text-red-500 text-sm" :message="formData.errors.rut" /> -->
      <small v-if="isValidRut === true" class="text-green-600">✅ RUT válido</small>
      <small v-else-if="isValidRut === false" class="text-red-600">❌ RUT inválido</small>
    </div>

    <!-- Correo -->
    <div class="col-span-6">
      <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Correo</label>
      <input type="email" v-model="formData.email" class="w-full border p-2 rounded-xl" required placeholder="Correo Electronico"/>
    </div>

    <!-- Telefono -->
    <div class="col-span-6">
      <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Teléfono</label>
      <Input
        id="phone"
        v-model="formData.phone"
        @input="checkPhone"
        type="text"
        class="w-full border p-2 rounded-xl"
        placeholder="Ingrese teléfono"
        :isRequired="true"
      />
      <small v-if="isPhoneValid === true" class="text-green-600">✅ Número válido</small>
      <small v-else-if="isPhoneValid === false" class="text-red-600">❌ Número inválido</small>
    </div>

    <!-- Direccion -->
    <div class="col-span-6">
      <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Dirección</label>
      <input type="text" v-model="formData.address" class="w-full border p-2 rounded-xl" required placeholder="Direccion"/>
    </div>

    <!-- Fecha de nacimiento -->
    <div class="col-span-6">
      <label for="DOB" class="block text-gray-700 text-sm font-bold mb-2">Fecha de nacimiento</label>
      <input type="date" v-model="formData.dob" class="w-full border p-2 rounded-xl" required />
    </div>

    <!-- AFP -->
    <div class="col-span-6">
      <SelectAFP
        v-model="formData.afp"
        inputClass="w-full border p-2 rounded-xl"
        labelClass="block text-gray-700 text-sm font-bold mb-2"
        :isRequired="true"
      />
    </div>

    <!-- Plan de Salud -->
    <div class="col-span-6">
      <label for="health_plan" class="block text-gray-700 text-sm font-bold mb-2">Plan de salud</label>
      <select v-model="formData.health_plan" class="w-full border p-2 rounded-xl" required>
        <option value="" disabled selected>Selecciona un plan de salud</option>
        <option value="Fonasa">Fonasa</option>
        <option value="Isapre">Isapre</option>
      </select>
    </div>

    <!-- Botón Registrar -->
    <div class="col-span-12">
      <Button
        type="submit"
        class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl w-full"
        size="base"
        :disabled="false"
      >
      {{ worker && Object.keys(worker).length > 0 ? 'Actualizar Colaborador' : 'Registrar colaborador' }}
        
      </Button>
    </div>
  </form>
</template>