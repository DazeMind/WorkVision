<template>
  <div class="bg-white shadow-md rounded-lg p-4">
    <!-- Header de la tarjeta -->
    <div class="flex justify-between items-center mb-4 cursor-pointer" @click="toggleCollapse">
      <h3 class="text-lg font-semibold flex items-center">
        <UserGroupIcon class="w-5 h-5 mr-2" />
        ASIGNAR COLABORADOR AL PROYECTO
      </h3>
      <!-- Botón Cerrar Modal -->
      <button @click="closeModal" class="text-gray-500 hover:text-gray-700 focus:outline-none">
        <span class="sr-only">Cerrar</span>
        <svg
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke-linecap="round"
          stroke-linejoin="round"
        >
          <path d="M6 18L18 6M6 6l12 12"></path>
        </svg>
      </button>
    </div>

    <!-- Contenido colapsable -->
    <transition name="fade">
      <div>
        <!-- Tabla de trabajadores -->
        <table class="min-w-full divide-y divide-gray-200">
          <!-- Encabezado de la tabla -->
          <thead class="bg-gray-100">
            <tr>
              <th
                scope="col"
                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
                <UserIcon class="w-5 h-5 text-gray-500 inline-block mr-2" />
                Nombre
              </th>
              <th
                scope="col"
                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
              <LocationMarkerIcon class="w-5 h-5 text-gray-500 inline-block mr-2" />
                Dirección
              </th>
              <th
                scope="col"
                class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"
              >
              <ExclamationCircleIcon class="w-5 h-5 text-gray-500 inline-block mr-2" />
                Estado
              </th>
            </tr>
          </thead>

          <!-- Cuerpo de la tabla -->
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(worker, index) in paginatedWorkers" :key="index" class="hover:bg-gray-50">
              <!-- Columna de nombre y checkbox -->
              <td class="px-4 py-2 whitespace-nowrap flex items-center">
                <UserIcon class="w-5 h-5 text-gray-500 mr-2 cursor-move" />
                <CheckIcon class="w-5 h-5 mr-2" v-if="worker.selected" />
                <input type="checkbox" v-model="worker.selected" @change="updateSelectedWorkers()" class="mr-2 cursor-pointer" />
                <span>{{ worker.first_name }}  {{ worker.first_last_name }}</span>
              </td>

              <!-- Columna de horas extras -->
              <td class="px-4 py-2 whitespace-nowrap">
                <small :class="getBadgeClass(worker.priority)">
                  <ClockIcon class="w-4 h-4 inline-block mr-1" />
                  {{ worker.address }}
                </small>
              </td>

              <!-- Columna de días asistidos -->
              <td class="px-4 py-2 whitespace-nowrap">
                <small :class="getBadgeClass(worker.priority)">
                  <CalendarIcon class="w-4 h-4 inline-block mr-1" />
                  {{ worker.state.name }}
                </small>
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Paginación -->
        <div class="flex justify-center space-x-2 mt-4">
          <button
            @click="changePage(currentPage - 1)"
            :disabled="currentPage === 1"
            class="text-gray-500 hover:text-gray-700"
          >
            «
          </button>
          <button
            v-for="page in totalPages"
            :key="page"
            @click="changePage(page)"
            :class="{
              'font-bold text-blue-500': currentPage === page,
              'text-gray-500': currentPage !== page
            }"
            class="hover:text-gray-700"
          >
            {{ page }}
          </button>
          <button
            @click="changePage(currentPage + 1)"
            :disabled="currentPage === totalPages"
            class="text-gray-500 hover:text-gray-700"
          >
            »
          </button>
        </div>

        <!-- Botón de marcar asistencia -->
        <div class="mt-4 flex justify-start">
          <button
            @click="sendSelectedWorkersToBackend"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center"
          >
            <UserAddIcon class="w-5 h-5 mr-2" />
            Agregar Colaborador al Proyecto
          </button>
        </div>
      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, defineEmits, defineProps,onMounted,watch } from 'vue'
import { CalendarIcon, CheckIcon, ClipboardCheckIcon, ClockIcon, ExclamationCircleIcon, LocationMarkerIcon, PencilAltIcon, TrashIcon, UserAddIcon, UserGroupIcon, UserIcon } from '@heroicons/vue/solid'
import { router } from '@inertiajs/vue3';

const emit = defineEmits()

const currentPage = ref(1)
const workersPerPage = ref(5)
const selectedWorkerIds = ref([]);

const props = defineProps({
  workers: { type: Array, required: false},
  proyectId: { type: Number, required: true},
  number: { type: Number, required: false},
});

// FUNCIONES 
const sendSelectedWorkersToBackend = async () => {
  router.post(route('worker_project.store', {  workerIds: selectedWorkerIds.value, proyectId: props.proyectId })).then(() => {
    // router.visit(route('worker'));
    console.log("s");
  }).catch(error => {
    console.error('Error al Asignar colaborador/es:', error);
    alert('Hubo un problema al enviar los datos. Error al Asignar colaborador/es');
  });
};
const updateSelectedWorkers = () => {
  selectedWorkerIds.value = props.workers
    .filter((worker) => worker.selected) 
    .map((worker) => worker.id);
};



const getBadgeClass = (priority) => {
  switch (priority) {
    case 'danger':
      return 'text-red-500'
    case 'info':
      return 'text-blue-500'
    case 'warning':
      return 'text-yellow-500'
    case 'primary':
      return 'text-indigo-500'
    case 'secondary':
      return 'text-gray-500'
    default:
      return 'text-gray-500'
  }
}

const closeModal = () => {
  emit('close') // Emite el evento para que el padre lo reciba
}

// PAGINATION
const toggleCollapse = () => { isCollapsed.value = !isCollapsed.value; };
const totalPages = computed(() => Math.ceil(props.workers.length / workersPerPage.value));
const paginatedWorkers = computed(() => {
  const start = (currentPage.value - 1) * workersPerPage.value;
  const end = start + workersPerPage.value;
  return props.workers.slice(start, end);
});
const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) { currentPage.value = page; }
};
//

onMounted(() => {
    console.log("WORKERs ASSIGN:", props.workers);
    console.log("NUMBER:", props.number);
  });
  watch(
    selectedWorkerIds,
    (newVal, oldVal) => {
      // console.log('selectedWorkerIds cambió:');
      // console.log('Nuevo valor:', newVal);
      // console.log('Valor anterior:', oldVal);
    }
  );
</script>
