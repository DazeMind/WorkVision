<template>
  <div class="bg-white shadow-md rounded-lg p-4">
    <!-- Header de la tarjeta -->
    <div class="flex justify-between items-center mb-4 cursor-pointer" @click="toggleCollapse">
      <h3 class="text-lg font-semibold flex items-center">
        📁 Archivos del Proyecto
      </h3>
      <button class="text-gray-500 hover:text-gray-700">
        <span v-if="isCollapsed">▼</span>
        <span v-else>▲</span>
      </button>
    </div>
    <!-- Módulo: Documentos del Proyecto -->
    <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Archivos del Proyecto"  v-show="!isCollapsed"> 
        <div>
            <details class="mb-3" open>
            <summary class="cursor-pointer text-blue-600 font-medium">📁 Contratos</summary>
            <ul class="mt-2 pl-5 list-disc">
                <li v-for="file in projectFiles.filter(f => f.file_type === 'contrato')" :key="file.id">
                <a :href="file.file_path" target="_blank" class="text-blue-500 hover:underline">{{ file.file_name }}</a>
                </li>
            </ul>
            </details>

            <details class="mb-3">
            <summary class="cursor-pointer text-green-600 font-medium">📁 Planos</summary>
            <ul class="mt-2 pl-5 list-disc">
                <li v-for="file in projectFiles.filter(f => f.file_type === 'plano')" :key="file.id">
                <a :href="file.file_path" target="_blank" class="text-green-500 hover:underline">{{ file.file_name }}</a>
                </li>
            </ul>
            </details>

            <details class="mb-3">
            <summary class="cursor-pointer text-purple-600 font-medium">📁 Presupuestos</summary>
            <ul class="mt-2 pl-5 list-disc">
                <li v-for="file in projectFiles.filter(f => f.file_type === 'presupuesto')" :key="file.id">
                <a :href="file.file_path" target="_blank" class="text-purple-500 hover:underline">{{ file.file_name }}</a>
                </li>
            </ul>
            </details>

            <details class="mb-3">
            <summary class="cursor-pointer text-gray-600 font-medium">📁 Otros</summary>
            <ul class="mt-2 pl-5 list-disc">
                <li v-for="file in projectFiles.filter(f => f.file_type === 'otro')" :key="file.id">
                <a :href="file.file_path" target="_blank" class="text-gray-500 hover:underline">{{ file.file_name }}</a>
                </li>
            </ul>
            </details>
        </div>

        <div class="mt-4 flex justify-end">
          <button @click="OpenModalFormFile" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
            <PlusCircleIcon class="w-5 h-5 mr-2" />
            Agregar Documento
          </button>
        </div>
    </div>
  </div>

    <Modal :show="isShowModalFormFile" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Subir Archivo</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes subir archivos relacionados a tu proyecto.</p>
            <form @submit.prevent="uploadFile" class="mt-4 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nombre del archivo</label>
                    <input v-model="fileForm.name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-dark-eval-2 dark:text-white" placeholder="Ej. Contrato Principal" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tipo de archivo</label>
                    <select v-model="fileForm.type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-dark-eval-2 dark:text-white" required>
                    <option value="" disabled>Selecciona una categoría</option>
                    <option value="contrato">Contrato</option>
                    <option value="plano">Plano</option>
                    <option value="presupuesto">Presupuesto</option>
                    <option value="imagen">Imagen</option>
                    <option value="otro">Otro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Archivo</label>
                    <input @change="handleFileUpload" type="file" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:border-0 file:rounded-md file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" required>
                </div>
            </form>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModalFormFile">Cancelar</Button>
        </div>
      </div>
    </Modal>
</template>

<script setup>
    import { ref, reactive, defineProps,onMounted } from 'vue';
    import { router } from '@inertiajs/vue3';
    import { PlusCircleIcon } from '@heroicons/vue/outline';
    import Modal from "@/Components/Modal.vue";

    const fileForm = reactive({
    name: '',
    type: '',
    file: null
    });

    const handleFileUpload = (e) => {
    fileForm.file = e.target.files[0];
    };

    const uploadFile = async() => {
    const formData = new FormData();
    formData.append('name', fileForm.name);
    formData.append('type', fileForm.type);
    formData.append('file', fileForm.file);
    formData.append('project_id', project.id);

    // Enviar a tu backend
    await router.post(route('project.files.upload'), formData)
        .then(() => {
        closeModal();
        // Refrescar lista de archivos (emitir evento o recargar data)
        })
        .catch(error => {
        console.error('Error al subir el archivo:', error);
        });
    };

  const props = defineProps({
    proyectId: Number,
    projectFiles: Array,
  });
  const isCollapsed = ref(false);
  const isShowModalFormFile = ref(false);

  const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
  };

  const OpenModalFormFile = () =>{
    isShowModalFormFile.value = true;
  }
  const closeModalFormFile = () =>{
    isShowModalFormFile.value = false;
  }
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