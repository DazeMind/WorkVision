<template>
    <AuthenticatedLayout title="Workers">
      <template #header>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h2 class="text-xl font-semibold leading-tight">
            Gestor de Colaboradores
          </h2>
        </div>
      </template>
  
      <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <Button
          external
          variant="black"
          class="items-center gap-2 max-w-xs bg-blue-700"
          href=""
          @click="toggleFormCreateWorker"
        >
          {{ mostrarComponenteFormCreateWorker ? 'Contraer formulario' : 'Crear nuevo colaborador' }}
        </Button>
      </div>

      <div v-if="$page.props.flash.message" class="mt-4 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">


        <FlashMessage
            :show="$page.props.flash.message"
            :on-dismiss="() => (showAlert = false)"
            :title="$page.props.flash.title"
            :content="$page.props.flash.content"
            :variant="$page.props.flash.type"
          /> 
      </div>

      <div v-if="mostrarComponenteFormCreateWorker">
        <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
          <div class="card">
            <FormCreateWorker                 
              :companies="companies" @closeModalCreate="toggleFormCreateWorker"
            />
          </div>
        </div>
      </div>

      <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <p class="text-lg font-semibold leading-tight mb-3">
            Mis Colaboradores
        </p>
        <div class="relative overflow-x-auto">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">ACCIONES</th>
                <th scope="col" class="px-6 py-3">ID</th>
                    <div v-for="(role, index) in user.roles" :key="index">
                      <th class="px-6 py-3" v-if="role.name === 'SuperAdmin'">
                        <span >Empleador</span>
                      </th>    
                    </div>
                    <th scope="col" class="px-6 py-3">Nombre</th>
                    <th scope="col" class="px-6 py-3">Rut</th>
                    <th scope="col" class="px-6 py-3">Correo</th>
                    <th scope="col" class="px-6 py-3">Cumpleaños</th>
                    <th scope="col" class="px-6 py-3">AFP</th>
                    <th scope="col" class="px-6 py-3">SALUD</th>
                </tr>
            </thead>
            <tbody>
                <!-- Iterar sobre las compañías -->
                <template v-for="(company, companyIndex) in companies" :key="companyIndex">
                    <!-- Iterar sobre los trabajadores de cada compañía -->
                    <tr v-for="(worker, workerIndex) in company.workers" :key="workerIndex">
                      <td class="px-6 py-3">
                        <Button variant="danger" title="Eliminar Colaborador" size="sm"
                              class="items-center gap-2 max-w-xs p-1"
                              @click="deleteWorker(worker)">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                  fill="currentColor" class="w-5 h-5">
                                  <TrashIcon></TrashIcon>
                              </svg>
                          </Button>                      
                        <Button variant="primary" title="Eliminar Colaborador" size="sm"
                              class="items-center gap-2 max-w-xs p-1 ms-1"
                              @click="updateWorker(worker)">
                              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                  fill="currentColor" class="w-5 h-5">
                                  <PencilIcon></PencilIcon>
                              </svg>
                          </Button>                      
                        </td>
                        <td class="px-6 py-3">{{ worker.id }}</td>
                      <div v-for="(role, index) in user.roles" :key="index">
                        <td class="px-6 py-3" v-if="role.name === 'SuperAdmin'">
                          <span >{{ company.name }}</span>
                        </td>    
                      </div>                
                        <td class="px-6 py-3">
                            {{ worker.first_name }} {{ worker.second_name }} {{ worker.first_last_name }} {{ worker.second_last_name }}
                        </td>
                        <td class="px-6 py-3">{{ worker.rut }}</td>
                        <td class="px-6 py-3">{{ worker.email }}</td>
                        <td class="px-6 py-3">{{ worker.date_of_birth }}</td>
                        <td class="px-6 py-3">{{ worker.afp }}</td>
                        <td class="px-6 py-3">{{ worker.health_plan }}</td>
                    </tr>
                </template>
            </tbody>
        </table>
        </div>
      </div>

    
  
    </AuthenticatedLayout>
  </template>
  
  <script setup>
  import { TrashIcon } from '@heroicons/vue/outline'
  import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
  import FormCreateWorker from '../Components/Worker/FormCreateWorker.vue';
  import Button from '@/Components/Button.vue';
  import { PencilIcon } from '@heroicons/vue/solid';
  import FlashMessage from '@/Components/FlashMessage.vue';
  import { router } from '@inertiajs/vue3'

  </script>
  
  <script>
  export default {
    data() {
      return {
        mostrarComponenteFormCreateWorker: false,
      };
    },
    methods: {
      toggleFormCreateWorker() {
        this.mostrarComponenteFormCreateWorker = !this.mostrarComponenteFormCreateWorker;
      },
      deleteWorker(worker){
        if (confirm(`¿Estás seguro de que quieres eliminar a ${worker.first_name} ${worker.first_last_name}?`)) {
          router.delete(route('worker.destroy', { id: worker.id }), {
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
        }
      },
      updateWorker(worker){
        this.$inertia.visit(route('worker.edit',{id:worker.id}));
      }
    },
    components: {
      FormCreateWorker,
      TrashIcon,
    },
    props: {
      companies: Array,
      user: Object,
      
    },
    computed: {
      //
    },
    mounted() {
      // console.log("Workers recibidos:", this.companies);
    },
  };
  </script>