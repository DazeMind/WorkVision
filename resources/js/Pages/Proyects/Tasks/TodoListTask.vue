<template>
  <div class="bg-white shadow-md rounded-lg p-4">
    <!-- Header de la tarjeta -->
    <div class="flex justify-between items-center mb-4 cursor-pointer" @click="toggleCollapse">
      <h3 class="text-lg font-semibold flex items-center">
        <PresentationChartBarIcon class="w-5 h-5 mr-2" />
        Planificación de proyecto
      </h3>
      <button class="text-gray-500 hover:text-gray-700">
        <span v-if="isCollapsed">▼</span>
        <span v-else>▲</span>
      </button>
    </div>
    
    <!-- Contenido colapsable -->
    <transition name="fade">
      <div v-if="!isCollapsed">
        <div class="my-5">
          <div class="flex justify-between mb-1">
            <span class="text-base font-medium text-blue-700 dark:text-white">Avance del proyecto</span>
            <span class="text-sm font-medium text-blue-700 dark:text-white">{{ avance }}%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
            <div class="bg-blue-600 h-2.5 rounded-full" :style="{ width: avance + '%' }"></div>
          </div>
        </div>

        <!-- Contenedor de tareas con columnas -->
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-3 gap-4">
          <!-- Columna Por Hacer -->
          <div class="bg-gray-100 p-4 rounded-lg">
            <h4 class="text-lg font-semibold mb-4">Por Hacer</h4>
            <draggable
              :itemKey="'id'"
              v-model="tasksByState['Tarea por hacer']"
              group="tasks"
              @change="onDrop($event, 'Tarea por hacer')" 
              :options="{ animation: 150, touchStartThreshold: 10, fallbackOnBody: true, dragClass: 'sortable-drag' }"
              class="space-y-2"
            >
            <template #item="{ element: task }">
              <div
                class="bg-white p-2 mb-2 rounded shadow cursor-pointer"
                draggable="true"
                @dragstart="(event) => onDragStart(task, event)"
                @click="toggleTask(task.id)"
              >
                {{ task.title }}
                <div class="flex items-center space-x-2">
                  <PencilAltIcon class="w-5 h-5 text-blue-500 cursor-pointer" @click.stop="showModalEditTask(task)" title="Editar tarea" />
                  <TrashIcon class="w-5 h-5 text-red-500 cursor-pointer" @click.stop="deleteTask(task)" title="Eliminar tarea" />
                </div>
                <p>
                  <span class="text-xs text-gray-400">
                    <CalendarIcon class="w-4 h-4 inline-block mr-1" /> Fecha límite:
                    {{ task.date ?? 'Sin Tiempo' }}
                  </span>
                  <span class="ml-4 text-xs text-gray-400">
                    <ClockIcon class="w-4 h-4 inline-block mr-1" /> Tiempo:
                    {{ task.time ?? 'Sin Tiempo' }}
                  </span>
                </p>
                <transition name="fade">
                  <p
                    v-if="expandedTaskId === task.id"
                    class="mt-2 text-gray-600 text-sm bg-gray-50 p-2 rounded"
                  >
                    {{ task.description }}
                  </p>
                </transition>
              </div>
            </template>
            </draggable>
          </div>

          <!-- Columna En Curso -->
          <div class="bg-blue-100 p-4 rounded-lg">
            <h4 class="text-lg font-semibold mb-4">En Curso</h4>
            <draggable
              :itemKey="'id'"
              v-model="tasksByState['En Proceso']"
              group="tasks"
              @change="onDrop($event, 'En Proceso')" 
              :options="{ animation: 150, touchStartThreshold: 10, fallbackOnBody: true, dragClass: 'sortable-drag' }"
              class="space-y-2"
            >
              <template #item="{ element: task }">
                <div
                  class="bg-white p-2 mb-2 rounded shadow cursor-pointer"
                  draggable="true"
                  @dragstart="(event) => onDragStart(task, event)"
                  @click="toggleTask(task.id)"
                >
                  {{ task.title }}
                  <div class="flex items-center space-x-2">
                    <PencilAltIcon class="w-5 h-5 text-blue-500 cursor-pointer" @click.stop="showModalEditTask(task)" title="Editar tarea" />
                    <TrashIcon class="w-5 h-5 text-red-500 cursor-pointer" @click.stop="deleteTask(task)" title="Eliminar tarea" />
                  </div>
                  <p>
                    <span class="text-xs text-gray-400">
                      <CalendarIcon class="w-4 h-4 inline-block mr-1" /> Fecha límite:
                      {{ task.date ?? 'Sin Tiempo' }}
                    </span>
                    <span class="ml-4 text-xs text-gray-400">
                      <ClockIcon class="w-4 h-4 inline-block mr-1" /> Tiempo:
                      {{ task.time ?? 'Sin Tiempo' }}
                    </span>
                  </p>
                  <transition name="fade">
                    <p
                      v-if="expandedTaskId === task.id"
                      class="mt-2 text-gray-600 text-sm bg-gray-50 p-2 rounded"
                    >
                      {{ task.description }}
                    </p>
                  </transition>
                </div>
              </template>
            </draggable>
          </div>

          <!-- Columna Finalizado -->
          <div class="bg-green-100 p-4 rounded-lg">
            <h4 class="text-lg font-semibold mb-4">Finalizado</h4>
            <draggable
              :itemKey="'id'"
              v-model="tasksByState['Finalizada']"
              group="tasks"
              @change="onDrop($event, 'Finalizada')" 
              :options="{ animation: 150, touchStartThreshold: 10, fallbackOnBody: true, dragClass: 'sortable-drag' }"
              class="space-y-2"
            >
              <template #item="{ element: task }">
                <div
                  class="bg-white p-2 mb-2 rounded shadow cursor-pointer"
                  draggable="true"
                  @dragstart="(event) => onDragStart(task, event)"
                  @click="toggleTask(task.id)"
                >
                  {{ task.title }}
                  <div class="flex items-center space-x-2">
                    <PencilAltIcon class="w-5 h-5 text-blue-500 cursor-pointer" @click.stop="showModalEditTask(task)" title="Editar tarea" />
                    <TrashIcon class="w-5 h-5 text-red-500 cursor-pointer" @click.stop="deleteTask(task)" title="Eliminar tarea" />
                  </div>
                  <p>
                    <span class="text-xs text-gray-400">
                      <CalendarIcon class="w-4 h-4 inline-block mr-1" /> Fecha límite:
                      {{ task.date ?? 'Sin Tiempo' }}
                    </span>
                    <span class="ml-4 text-xs text-gray-400">
                      <ClockIcon class="w-4 h-4 inline-block mr-1" /> Tiempo:
                      {{ task.time ?? 'Sin Tiempo' }}
                    </span>
                  </p>
                  <transition name="fade">
                    <p
                      v-if="expandedTaskId === task.id"
                      class="mt-2 text-gray-600 text-sm bg-gray-50 p-2 rounded"
                    >
                      {{ task.description }}
                    </p>
                  </transition>
                </div>
              </template>
            </draggable>
          </div>
        </div>
        <div class="mt-4 flex justify-end">
          <button @click="OpenModalFormTask" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
            <PlusCircleIcon class="w-5 h-5 mr-2" />
            Agregar Tarea
          </button>
        </div>
      </div>
    </transition>
    
        

        <div v-if="isModalFormTaskVisible" class="modal-overlay fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
          <div class="modal-content bg-white p-6 rounded-lg md:w-1/2 lg:w-1/2">
            <FormTask @close="closeModal" :proyectId="proyectId" :taskpriorities="taskpriorities" :workers="workers_project" />
          </div>
        </div>
  </div>

  <Modal :show="isShowModalEditTask" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Editar Tarea</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes editar una tarea.</p>
          <FormTask :task="selectedTask" :proyectId="proyectId" :taskpriorities="taskpriorities" :workers="workers_project"/>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModalEdit">Cancelar</Button>
        </div>
      </div>
    </Modal>
</template>

<script setup>
  import { ref, computed, defineProps,onMounted } from 'vue';
  import { CalendarIcon, ClipboardListIcon, ClockIcon, PencilAltIcon, PlusCircleIcon, PresentationChartBarIcon, TrashIcon, } from '@heroicons/vue/solid';
  import { router } from '@inertiajs/vue3';
  import FormTask from './FormTask.vue';
  import draggable from 'vuedraggable';
  import CalendarTasks from '@/Pages/Components/Proyect/Task/CalendarTasks.vue';
  import GantTasks from '@/Pages/Components/Proyect/Task/GantTasks.vue';
  import Button from '@/Components/Button.vue';
  import Modal from "@/Components/Modal.vue";


  const props = defineProps({
    tasks: Array,
    workers_project: Array,
    proyectId: Number,
    taskpriorities: Array,
  });

  const selectedTask = ref({
    title: '',
    description: '',
    date: '',
    time: '',
    priority: '',
    id_state: '',
  });

  const isModalFormTaskVisible = ref(false);
  const isShowModalEditTask = ref(false);
  const isCollapsed = ref(false);
  const currentPage = ref(1);
  const tasksPerPage = ref(5);
  
  const avance = props.tasks && props.tasks.length > 0
  ? Math.round((props.tasks.filter(task => task.id_state == 1).length / props.tasks.length) * 100) : 0;
  const draggedTask = ref(null);
  // Estado para controlar cuál tarea está expandida
  const expandedTaskId = ref(null);

  // Función para manejar el clic y alternar el estado de expansión
  const toggleTask = (taskId) => {
    expandedTaskId.value = expandedTaskId.value === taskId ? null : taskId;
  };
// Agrupar tareas por estado
const tasksByState = computed(() => {
  return {
    'Tarea por hacer': props.tasks.filter((task) => task.state.name === 'Tarea por hacer'),
    'En Proceso': props.tasks.filter((task) => task.state.name === 'En Proceso'),
    'Finalizada': props.tasks.filter((task) => task.state.name === 'Finalizada'),
  };
});

// Función para manejar el inicio del arrastre
const onDragStart = (task) => {
  console.log("dragstart");
  draggedTask.value = task;
  console.log('Elemento arrastrado asignado:', draggedTask.value);
};

// Función para manejar el soltar
const onDrop = (event, newState) => {
  if (!draggedTask.value) return;
  console.log("Tarea movida a:", newState);

  // Encontrar y actualizar el estado localmente
  const taskIndex = props.tasks.findIndex(task => task.id === draggedTask.value.id);
  if (taskIndex !== -1) {
    props.tasks[taskIndex].state.name = newState;

    // Sincronizar con el backend
    const updatedTask = { ...props.tasks[taskIndex] };
    router.put(route('tasks.updateState', { id: updatedTask.id }), updatedTask, {
      preserveState: true,
      onError: (error) => {
        console.error('Error al actualizar la tarea:', error);
        // Restaurar el estado anterior si ocurre un error
        props.tasks[taskIndex].state.name = draggedTask.value.state.name;
      },
    });
  }

  // Limpiar la tarea arrastrada
  draggedTask.value = null;
};


  const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
  };
  const showModalEditTask = (task) => {
    selectedTask.value = { ...task }; // Copiar los datos de la tarea seleccionada
    isShowModalEditTask.value = true; // Mostrar el modal
  };
  const closeModalEdit = () => {
    isShowModalEditTask.value = false; // Mostrar el modal
  };

// const getBadgeClass = (priority) => {
//   switch (priority) {
//     case '2':
//       return 'text-red-500';
//     case 'baja':
//       return 'text-blue-500';
//     case '1':
//       return 'text-yellow-500';
//     case 'primary':
//       return 'text-indigo-500';
//     case 'secondary':
//       return 'text-gray-500';
//     default:
//       return 'text-gray-500';
//   }
// };


// FUNCIONES
const taskComplete = (id) => {
  console.log("hola",id);
  router.post(route('task.complete',id)).then(()=>{
    console.log("completado con exito");
    task.id_state = task.completed ? 1 : 3;
  }).catch(error => {
    console.error('Error al completar:', error);
  });
};

const editTask = (task) => {
    if (confirm(`¿Estás seguro de que quieres editar la tarea '${task.title}' del proyecto ?`)) {
      router.delete(route('tasks.destroy', { id: task.id })).then(() => {
        console.log("editado con exito");
      }).catch(error => {
        console.error('Error al editar colaborador:', error);
      });
    }
};
const deleteTask = (task) => {
    if (confirm(`¿Estás seguro de que quieres eliminar la tarea '${task.title}' del proyecto ?`)) {
      router.delete(route('tasks.destroy', { id: task.id })).then(() => {
        console.log("eliminado con exito");
      }).catch(error => {
        console.error('Error al eliminar colaborador:', error);
      });
    }
};

// MODAL
const OpenModalFormTask = () => {
  isModalFormTaskVisible.value = true;
};
const closeModal = () => {
  isModalFormTaskVisible.value = false;
};

// PAGINATION
const totalPages = computed(() => Math.ceil(props.tasks.length / tasksPerPage.value));
const paginatedTasks = computed(() => {
  const start = (currentPage.value - 1) * tasksPerPage.value;
  const end = start + tasksPerPage.value;
  return props.tasks.slice(start, end);
});

onMounted(() => {
    console.log("modal:", isShowModalEditTask.value);
    props.tasks.forEach(task => {
      task.completed = task.id_state === 1;
    });
  });
</script>

<style scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
</style>