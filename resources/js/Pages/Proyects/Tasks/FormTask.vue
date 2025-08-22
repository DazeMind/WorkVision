<script setup>
import { ref, reactive, watch, onMounted, defineProps, defineEmits } from 'vue';
import { router } from '@inertiajs/vue3';
import Button from '@/Components/Button.vue';
import Input from '@/Components/Input.vue';
import FlashMessage from '@/Components/FlashMessage.vue';

const props = defineProps({
  task: { type: Object, required: false, default: () => ({}),},
  proyectId: { type: Number, required: true},
  taskpriorities: { type: Array, required: true},
  workers: { type: Array, required: false},
});

const formData = reactive({
    id_project: props.proyectId,
    id_worker_project: props.task?.id_worker_project || '',
    title: props.task?.title || '',
    description: props.task?.description || '',
    priority: props.task?.priority?.id || '',
    date: props.task?.date || '',
    time: props.task?.time || '',
    id_state: props.task?.id_state || '',
});

// Emits
const emit = defineEmits(['close']);

// Variables
const timeError = ref('');
const isValidRut = ref(false);
// const flashMessage = reactive({ ...flash });


// Funciones
const enviarFormulario = async () => {
  if (timeError.value) {
      console.log('Error en el formato del tiempo, no se enviará el formulario.');
      return;
  }

  try {
      if (props.task?.id) {
          // Si hay una tarea existente, actualizar
          await router.put(route('tasks.update', props.task.id), formData);
          console.log('Tarea actualizada:', formData);
      } else {
          // Si no hay tarea, crear una nueva
          await router.post(route('tasks.store'), formData);
          console.log('Tarea creada:', formData);
      }
      closeModal(); // Cerrar modal después de enviar
  } catch (error) {
      console.error('Error al enviar formulario:', error);
  }
};

const validateTimeFormat = () => {
  const regex = /^(\d+d)?\s*(\d+h)?$/;
  timeError.value = !regex.test(formData.time);
};
const closeModal = () => {
  emit('close');
};

  onMounted(() => {
    console.log("WORKES FORMTASK:", props.workers);
  });
</script>

<template>
  <!-- Botón Cerrar Modal -->
   <div class="flex justify-end">
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

  <!-- Formulario -->
  <form @submit.prevent="enviarFormulario" class="grid gap-6 max-w-full mt-2">
    <!-- Campos del formulario -->
    <div class="col-span-12">
      <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la tarea <span class="text-red-600">(*)</span></label>
      <Input type="text" v-model="formData.title" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Nombre ..." />
    </div>

    <div class="col-span-12">
      <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
      <textarea v-model="formData.description" class="w-full border p-2 rounded-xl" rows="4" placeholder="Descripción ..."></textarea>
    </div>

    <!-- Empresa -->
    <div class="col-span-6">
      <label for="id_worker_project" class="block text-gray-700 text-sm font-bold mb-2">Asigna la tarea a un responsable</label>
      <select v-model="formData.id_worker_project" class="w-full border p-2 rounded-xl">
        <option value="" disabled selected>Selecciona un colaborador</option>
        <option v-for="(worker, index) in props.workers" :key="index" :value="worker.id">
          {{ worker.worker.first_name }} {{ worker.worker.first_last_name }}
        </option> 
      </select>
    </div>

    <div class="col-span-6">
        <label for="priority" class="block text-gray-700 text-sm font-bold mb-2">Asigna una prioridad <span class="text-red-600">(*)</span></label>
        <select select v-model="formData.priority" class="w-full border p-2 rounded-xl" required>
            <option value="" disabled selected>Selecciona una prioridad</option>
            <option v-for="(taskpriority, index) in taskpriorities" :key="index" :value="taskpriority.id">
              {{ taskpriority.name }}
            </option>
      </select>
    </div>

    <div class="col-span-6">
      <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Fecha de realización</label>
      <input type="date" v-model="formData.date" class="w-full border p-2 rounded-xl"  />
    </div>

    <div class="col-span-6">
      <label for="value" class="block text-gray-700 text-sm font-bold mb-2">Tiempo asignado a la tarea</label>
      <input
        type="text"
        v-model="formData.time"
        class="w-full border p-2 rounded-xl"
        placeholder="Ejemplo: 1d 3h"
        @input="validateTimeFormat"
      />
      <small v-if="timeError" class="text-red-500">Formato inválido. Usa 'Xd Xh', por ejemplo, '2d 4h'.</small>
    </div>

    <!-- <div class="my-3 rounded-lg">
      <FlashMessage :show="showAlert" :on-dismiss="() => (showAlert = false)" :title="flashMessage.title" :content="flashMessage.content" :variant="flashMessage.type || 'danger'" />
    </div> -->

    <!-- Botón -->
    <div class="col-span-12 mb-6">
      <Button type="submit" class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl w-full" size="base">
        Registrar tarea
      </Button>
    </div>
  </form>
</template>
