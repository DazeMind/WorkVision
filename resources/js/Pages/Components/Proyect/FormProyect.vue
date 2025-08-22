<script setup>
    import Button from '@/Components/Button.vue'
    import Input from '@/Components/Input.vue';
    import FlashMessage from '@/Components/FlashMessage.vue';
    import CompanySelect from '@/Components/Selects/CompanySelect.vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import { ref } from 'vue';
import ValidationErrors from '@/Components/ValidationErrors.vue';

    const props = defineProps({
      clients: Object,
      companies: Object,
      flash: Object,
      states: Array,
      project: {
        type: Object,
        required: false,
        default: () => ({})
      }   
    });


    // const query = ref('')
    // const results = ref([])

    // const searchLocation = async () => {
    //       if (query.value.length < 3) {
    //         results.value = []
    //         return
    //       }

    //       const url = `https://nominatim.openstreetmap.org/search?format=json&addressdetails=1&countrycodes=cl&q=${encodeURIComponent(query.value)}`
    //       const res = await fetch(url)
    //       results.value = await res.json()
    //     }

    //     const selectPlace = (place) => {
    //       query.value = place.display_name
    //       results.value = []
    // }

    const errorrut =  '';
    const isValidRut = ref(false);
    
    const formData = useForm ({
      name: props.project.name || "",
      description: props.project.description || "",
      start_date: props.project.start_date || "",
      end_date: props.project.end_date || "",
      value: props.project.value || "",
      budget: props.project.budget || "",
      address: props.project.address || "",
      id_company: props.project.companies?.id || "",
      status: props.project.status || "",
      date: new Date().toISOString().slice(0, 10),
    });
      
    const enviarFormulario = async () => {
      formData.post(route('proyect.store'), {
          onSuccess: () => {
            console.log("¡Proyecto creado con éxito!");
          },
          onError: (errors) => {
              alert("Ha ocurrido un error al crear el proyecto. Por favor, revisa los campos.");
              console.error("Errores del servidor:", errors);
          },
          onFinish: () => {
              console.log("Proceso de envío de formulario para 'proyecto' finalizado.");
          }
      });
    }

  </script>


<template>
  <ValidationErrors class="mb-4" />
  <form @submit.prevent="enviarFormulario" class="mt-4 grid gap-6 max-w-4xl mx-auto mt-8 grid-cols-1 sm:grid-cols-2 lg:grid-cols-2">
  <!-- Empresa -->
  <div class="col-span-1 sm:col-span-2">
    <CompanySelect
        v-model="formData.id_company"
        :options="companies"
        label="Selecciona la empresa"
        input-id="id_company"
        :required="true"
      />
  </div>

  <!-- Nombre -->
  <div class="col-span-1">
    <label for="proyect_name" class="block text-gray-700 text-sm font-bold mb-2">Nombre del proyecto</label>
    <Input type="text" v-model="formData.name" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Nombre ..." />
  </div>

  <!-- Fecha de inicio -->
  <div class="col-span-1">
    <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de inicio</label>
    <Input type="date" v-model="formData.start_date" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Fecha de inicio" />
  </div>

  <!-- Fecha finalización -->
  <div class="col-span-1">
    <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Fecha finalización</label>
    <Input type="date" v-model="formData.end_date" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Fecha finalización"/>
  </div>

  <!-- Dirección -->
  <div class="col-span-1">
    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Ubicación del proyecto</label>
    <input type="text" v-model="formData.address" class="w-full border p-2 rounded-xl" required placeholder="Dirección"/>
  </div>

  <!-- <div>
    <input
      type="text"
      v-model="query"
      @input="searchLocation"
      placeholder="Buscar ubicación"
      class="border p-2 w-full"
    />
    <ul v-if="results.length" class="bg-white border mt-2">
      <li
        v-for="(place, index) in results"
        :key="index"
        @click="selectPlace(place)"
        class="p-2 cursor-pointer hover:bg-gray-100"
      >
        {{ place.display_name }}
      </li>
    </ul>
  </div> -->

  <!-- Valor a cobrar -->
  <div class="col-span-1">
    <label for="value" class="block text-gray-700 text-sm font-bold mb-2">Valor Presupuesto (a cobrar)</label>
    <Input type="text" v-model="formData.value" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Valor a cobrar"/>
  </div>

  <!-- Valor a gastar -->
  <div class="col-span-1">
    <label for="budget" class="block text-gray-700 text-sm font-bold mb-2">Valor Costo (a gastar)</label>
    <Input type="text" v-model="formData.budget" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Valor a gastar"/>
  </div>

  <!-- Estado adicional del proyecto -->
  <div class="col-span-1">
    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Estado adicional del proyecto</label>
    <Input type="text" v-model="formData.status" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Estado adicional"/>
  </div>

  <!-- Descripción -->
  <div class="col-span-1 sm:col-span-2">
    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
    <textarea
      id="description"
      v-model="formData.description"
      class="w-full border p-2 rounded-xl"
      placeholder="Descripción ..."
      rows="4"
    ></textarea>
  </div>

  <!-- Botón Registrar -->
  <div class="col-span-1 sm:col-span-2">
    <Button
      type="submit"
      class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl w-full"
      size="base"
      @click="enviarFormulario()"
    >
      Registrar proyecto        
    </Button>
  </div>
</form>

  

<!-- <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Nombre
                </th>
                <th scope="col" class="px-6 py-3">
                    Ciudad
                </th>
                <th scope="col" class="px-6 py-3">
                    Rol
                </th>
                <th scope="col" class="px-6 py-3">
                    Action
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Apple MacBook Pro 17"
                </th>
                <td class="px-6 py-4">
                    Silver
                </td>
                <td class="px-6 py-4">
                    Laptop
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center me-4">
                      <input checked
                      
                      id="teal-checkbox" type="checkbox" value="" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="teal-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Teal</label>
                  </div>                
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Magic Mouse 2
                </th>
                <td class="px-6 py-4">
                    Black
                </td>
                <td class="px-6 py-4">
                    Accessories
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center me-4">
                      <input  id="teal-checkbox" type="checkbox" value="" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="teal-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Teal</label>
                  </div>                
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Google Pixel Phone
                </th>
                <td class="px-6 py-4">
                    Gray
                </td>
                <td class="px-6 py-4">
                    Phone
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center me-4">
                      <input  id="teal-checkbox" type="checkbox" value="" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="teal-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Teal</label>
                  </div>                
                </td>
            </tr>
            <tr>
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Apple Watch 5
                </th>
                <td class="px-6 py-4">
                    Red
                </td>
                <td class="px-6 py-4">
                    Wearables
                </td>
                <td class="px-6 py-4">
                  <div class="flex items-center me-4">
                      <input  id="teal-checkbox" type="checkbox" value="" class="w-4 h-4 text-teal-600 bg-gray-100 border-gray-300 rounded focus:ring-teal-500 dark:focus:ring-teal-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                      <label for="teal-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Teal</label>
                  </div>                
                </td>
            </tr>
        </tbody>
    </table>
</div> -->

</template>