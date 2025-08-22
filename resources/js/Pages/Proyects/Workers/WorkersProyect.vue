<template>
  <div class="bg-white shadow-md rounded-lg p-4">
    <!-- Header de la tarjeta -->
    <div class="flex justify-between items-center mb-4 cursor-pointer" @click="toggleCollapse">
      <h3 class="text-lg font-semibold flex items-center">
        <UserGroupIcon class="w-5 h-5 mr-2" />
        GESTIÓN DE ASISTENCIA Y COLABORADORES
        <!-- <code class="ml-4">(pagos próximamente)</code> -->
        <code class="ml-4">(Fecha : {{ today }})</code>
      </h3>
      <!-- Botón para colapsar/expandir -->
      <button class="text-gray-500 hover:text-gray-700">
        <span v-if="isCollapsed">▼</span>
        <span v-else>▲</span>
      </button>
    </div>

    <!-- Contenido colapsable -->
    <transition name="fade">
      <div v-if="!isCollapsed">
        <!-- Tabla de trabajadores -->
        <table class="min-w-full divide-y divide-gray-200">
          <!-- Encabezado de la tabla -->
          <thead class="bg-gray-100">
            <tr>
              <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                <UserIcon class="w-5 h-5 text-gray-500 inline-block mr-2" />
                Nombre
              </th>
              <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Asistido
              </th>
              <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Días asistidos
              </th>
              <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Horas extras
              </th>
              <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Acciones
              </th>
            </tr>
          </thead>

          <!-- Cuerpo de la tabla -->
          <tbody class="bg-white divide-y divide-gray-200">
            <tr
              v-for="(workerProject, index) in paginatedWorkers"
              :key="index"
              class="hover:bg-gray-50"
            >
              <!-- Columna de nombre y checkbox -->
              <td class="px-4 py-2 whitespace-nowrap flex items-center">
                <UserIcon class="w-5 h-5 text-gray-500 mr-2 cursor-move" />
                <CheckIcon class="w-5 h-5 mr-2" v-if="workerProject.selected" /> 
                <input type="checkbox" v-model="workerProject.selected" @change="updateSelectedWorkers" class="mr-2 cursor-pointer" v-if="!hasAttendanceForToday(workerProject)"/>
                <span>{{workerProject.worker.first_name}} {{workerProject.worker.first_last_name }}</span>
              </td>

              <td class="px-4 py-2 whitespace-nowrap">
                <div class="inline-block">
                  <CheckIcon class="w-5 h-5 inline-block mr-1" v-if="hasAttendanceForToday(workerProject)"/>
                  <!-- <input type="checkbox" v-model="workerProject.selected" @change="updateSelectedWorkers" class="mr-2 cursor-pointer" v-if="hasAttendanceForToday(workerProject)"/> -->
                </div>
              </td>
              
              <!-- Columna de días asistidos -->
              <td class="px-4 py-2 whitespace-nowrap">
                <small :class="getBadgeClass(workerProject.priority)">
                  <CalendarIcon class="w-4 h-4 inline-block mr-1" />

                  {{ workerProject.worker.attendance.length }}
                </small>
              </td>

              <td class="px-4 py-2 whitespace-nowrap">
                <small :class="getBadgeClass(workerProject.priority)">
                  <ClockIcon class="w-4 h-4 inline-block mr-1" />
                  NO ASIGNADO
                </small>
              </td>

              <!-- Columna de acciones -->
              <td class="px-4 py-2 whitespace-nowrap flex space-x-2">
                <!-- <PencilAltIcon class="w-5 h-5 text-blue-500 cursor-pointer" title="Editar trabajador" />  -->
                <TrashIcon @click="deleteWorkerToProject(workerProject)" class="w-5 h-5 text-red-500 cursor-pointer"  title="Eliminar trabajador" />
              </td>
            </tr>
          </tbody>
        </table>

        <!-- Paginación -->
        <div class="flex justify-center space-x-2 mt-4">
          <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="text-gray-500 hover:text-gray-700">
            «
          </button>
          <button
            v-for="page in totalPages"
            :key="page"
            @click="changePage(page)"
            :class="{'font-bold text-blue-500': currentPage === page, 'text-gray-500': currentPage !== page}"
            class="hover:text-gray-700"
          >
            {{ page }}
          </button>
          <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="text-gray-500 hover:text-gray-700">
            »
          </button>
        </div>

        <!-- Botón de marcar asistencia -->
        <div class="mt-4 flex justify-start">
          <button @click="sendSelectedWorkersToBackend" :disabled="selectedWorkerIds.length === 0"  class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
            <ClipboardCheckIcon class="w-5 h-5 mr-2" />
            Marcar asistencia de hoy
          </button>
        </div>
        <div class="mt-4 flex justify-end">
          <button  @click="OpenModalAssingWorkerToProject" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
            <UserAddIcon class="w-5 h-5 mr-2" />
            Agregar Colaboradores al proyecto
          </button>
        </div>

        <!-- Modal -->
        <div v-if="isModalAssingWorkerToProjectVisible" class="modal-overlay fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
          <div class="modal-content bg-white p-6 rounded-lg w-1/2">
            <AssingWorkerToProject @close="closeModal" :workers="allWorkers" :proyectId="proyectId" />
          </div>
        </div>

      </div>
    </transition>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch} from 'vue';
import { CalendarIcon, CheckIcon, ClipboardCheckIcon, ClockIcon, PencilAltIcon, TrashIcon, UserGroupIcon, UserIcon,UserAddIcon } from '@heroicons/vue/solid';
import { defineProps } from 'vue';
import { router } from '@inertiajs/vue3';
import AssingWorkerToProject from './AssingWorkerToProject.vue';

// DEFINIR PROPS
const props = defineProps({
  workers_project: { type: Array, required: false},
  allWorkers: { type: Object, required: false},
  proyectId: { type: Number, required: true},
});

//DECLARAR
const selectedWorkerIds = ref([]);
const isCollapsed = ref(false);
const currentPage = ref(1);
const workersPerPage = ref(5);
const today = ref('');
const isModalAssingWorkerToProjectVisible = ref(false);


//FUNCIONES
const sendSelectedWorkersToBackend = async () => {
  router.post(route('attendances.store', {  workerIds: selectedWorkerIds.value, proyectId: props.proyectId })).then(() => {
    // router.visit(route('worker'));
  }).catch(error => {
    console.error('Error al eliminar colaborador:', error);
    alert('Hubo un problema al enviar los datos.');
  });
};

const deleteWorkerToProject = (workerProject) => {
    if (confirm(`¿Estás seguro de que quieres eliminar a ${workerProject.worker.first_name} ${workerProject.worker.first_last_name} del proyecto ?`)) {
      router.delete(route('worker_project.destroy', { id: workerProject.id })).then(() => {
        console.log("eliminado con exito");
      }).catch(error => {
        console.error('Error al eliminar colaborador:', error);
      });
    }
};

const updateSelectedWorkers = () => {
  selectedWorkerIds.value = props.workers_project
  .filter((workers_project) => workers_project.selected)
  .map((workers_project) => workers_project.worker.id);
};
// MODAL
const OpenModalAssingWorkerToProject = () => {
  isModalAssingWorkerToProjectVisible.value = true;
};
const closeModal = () => {
  isModalAssingWorkerToProjectVisible.value = false;
};
//


const getCurrentDate = () => {
  const now = new Date();
  const year = now.getFullYear();
  const month = String(now.getMonth() + 1).padStart(2, '0');
  const day = String(now.getDate()).padStart(2, '0');
  today.value = `${year}-${month}-${day}`;
};
const hasAttendanceForToday = (workerProject) => {
  return workerProject.worker.attendance.some(
    (att) => att.date === today.value
  );
};



const getBadgeClass = (priority) => {
  switch (priority) {
    case 'danger':
      return 'text-red-500';
    case 'info':
      return 'text-blue-500';
    case 'warning':
      return 'text-yellow-500';
    case 'primary':
      return 'text-indigo-500';
    case 'secondary':
      return 'text-gray-500';
    default:
      return 'text-gray-500';
  }
};
  
  // MOUNTED
  onMounted(() => {
    getCurrentDate();
    // console.log("WORKER PROJECT:", props.workers_project);
  });
  //WATCH
  watch(
    selectedWorkerIds,
    (newVal, oldVal) => {
      // console.log('selectedWorkerIds cambió:');
      // console.log('Nuevo valor:', newVal);
      // console.log('Valor anterior:', oldVal);
    }
  );

  // PAGINACION
  const toggleCollapse = () => { isCollapsed.value = !isCollapsed.value; };
  const totalPages = computed(() => Math.ceil(props.workers_project.length / workersPerPage.value));
  const paginatedWorkers = computed(() => {
    const start = (currentPage.value - 1) * workersPerPage.value;
    const end = start + workersPerPage.value;
    return props.workers_project.slice(start, end);
  });
  const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) { currentPage.value = page; }
  };
  //
</script>
