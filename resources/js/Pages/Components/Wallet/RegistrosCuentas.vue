<script setup>
  import Button from '@/Components/Button.vue'
  import DynamicMultiSelect from "@/Components/DynamicMultiSelect.vue";
  import Label from "@/Components/Label.vue";
  import Input from '@/Components/Input.vue';
  import { TrashIcon } from '@heroicons/vue/outline';
  import { PencilAltIcon } from '@heroicons/vue/solid';
  import Modal from "@/Components/Modal.vue";
  import FlashMessage from '../../../Components/FlashMessage.vue';
</script>
<script>
  export default {
    props: {
        registros: Array,
        wallets: Array,
        categories: Array,
        programRecords: Array,
        flash: { type: Object, default: () => [] }    
    },
    components:{
      FlashMessage,
      DynamicMultiSelect,
      Modal,
    },
    
    data() {
      return {
        showModalImage: null,
        modalImageUrl: null,
        flashMessage: window.flashMessage || null,
        showAlert: false, // Para mostrar u ocultar el mensaje flash
        filteredCategories:[],
        editProgramRecord: {
          DOTM: null,
          id_wallet: null,
          amount: null,
          description: null,
          type: null,
          category: null,
        },
        showModal: false,
        filters:{
          category:[],
          wallet:[],
          date_start: null,
          date_end: null,
        },
        formData: {
          walletTypes: "",
          amount: "",
          color: "",
          numberAccount: "",
          date: new Date().toISOString().slice(0, 10), // Establecer la fecha actual
        },
      };
    },
    methods: {
      openImageModal(url) {
        this.modalImageUrl = url
        this.showModalImage = true
      },
      handleCategoryChange(event) {
        if (event.target.value === "create") { // Siempre abrir modal si se selecciona "create"
          this.openCreateCategoryModal();
          this.editProgramRecord.category = "";
        }
      },
      filterCategories() {
        if (this.editProgramRecord.type !== null) {
          this.filteredCategories = this.categories.filter(category => {
            const typeMap = { income: "1", expense: "2" }; // Mapeo de valores
            return String(category.type) === typeMap[this.editProgramRecord.type];
          });
        }        
      },
      openCreateCategoryModal(programRecord) {
        this.editProgramRecord = { 
          ...programRecord.record, 
          DOTM: programRecord.DOTM,
          id_programRecord: programRecord.id 
        };
        this.showModal = true;
      },
      closeModal() {
        this.showModal = false;
        this.editProgramRecord = {};
      },
      DownloadFilteredRecordsExcel() {
          window.location.href = 'DownloadFilteredRecordsExcel';
      },
      async enviarFormulario() {
          const requestData = {
              formData: this.formData,
          };
          const response = await this.$inertia.post('wallet',requestData);
      },
      async deleteProgramRecord(programRecord) {
        if (confirm(`¿Estás seguro de que quieres eliminar el registro programado ( MONTO:${programRecord.record.amount} DESCRIPCION: ${programRecord.record.description})?`)) {
            this.$inertia.delete(route('programRecords.destroy', { id: programRecord.id }), {
                preserveScroll: true,
                onSuccess: () => {
                    this.$inertia.visit(route('Cuentas'));
                },
                onError: (error) => {
                    console.error('Error al eliminar registro:', error);
                }
            });
        }
      },
      async deleteRecord(registro) {
        if (confirm(`¿Estás seguro de que quieres eliminar el registro MONTO:${registro.amount} DESCRIPCION: ${registro.description}?`)) {
            this.$inertia.delete(route('finance.destroy', { finance: registro.id }), {
                data: registro,  // Aquí enviamos el objeto completo
                preserveScroll: true,
                onSuccess: () => {
                    this.$inertia.visit(route('Cuentas'));
                },
                onError: (error) => {
                    console.error('Error al eliminar registro:', error);
                }
            });
        }
      },
      async SendEditProgramRecord(editProgramRecord) {
        if (confirm('¿Estás seguro de que quieres editar el registro programado?')) {
            this.$inertia.post(route('programRecords.update', { id: this.editProgramRecord.id_programRecord }), {
                data: this.editProgramRecord,
                preserveScroll: true,
            });
        }
        window.location.reload();
      },
    },
    mounted() {
        // console.log("REGISTROS:", this.registros);
    },
    computed: {
      filteredRegisters() {
        return this.registros.filter((registro) => {
          // Filtro por categorías
          const matchesCategory =
            this.filters.category.length === 0 ||
            this.filters.category.includes(registro.category.id);

          // Filtro por billeteras
          const matchesWallet =
            this.filters.wallet.length === 0 ||
            this.filters.wallet.includes(registro.wallet.id);

          // Filtro por rango de fechas
          const matchesDate =
            (!this.filters.date_start ||
              new Date(registro.date) >= new Date(this.filters.date_start)) &&
            (!this.filters.date_end ||
              new Date(registro.date) <= new Date(this.filters.date_end));

          // Solo incluir registros que cumplan con todos los filtros
          return matchesCategory && matchesWallet && matchesDate;
        });
      },
      // filteredRegisters() {
      //   // Si no hay categorías seleccionadas, mostrar todos los registros
      //   if (this.filters.category.length === 0) {
      //     return this.registros;
      //   }
      //   // Filtrar registros según las categorías seleccionadas
      //   return this.registros.filter((registro) =>
      //     this.filters.category.includes(registro.category.id)
      //   );
      // },
    },
    
    watch: {
      '$page.props.flash': {
        handler(newFlash) {
          // console.log("flash");
          // console.log(newFlash);
          if (newFlash && typeof newFlash === 'object') {
            this.flashMessage = {
              title: newFlash.title || '',
              content: newFlash.content || '',
              type: newFlash.type || '', // Tipo por defecto
            };
            this.showAlert = true;
            this.showModal = false;

            setTimeout(() => {
              this.showAlert = false;
            }, 7000);
          }
        },
        deep: true,
        immediate: true
      },
      'editProgramRecord.type': function(newType) {
        this.filterCategories(); 
      },
    }
  }
</script>

<template>
    <div class="mt-5">
      <div class="my-4 flex flex-col gap-4">
          <!-- <FlashMessage
            :show="showAlert"
            :on-dismiss="() => (showAlert = false)"
            :title="flashMessage.title"
            :content="flashMessage.content"
            :variant="flashMessage.type"
          /> -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Campo de selección con su etiqueta -->
          <div class="flex flex-col">
            <Button
              variant="primary"
              size="sm"
              class=" items-center gap-2 max-w-xs text-white font-medium rounded-lg text-sm px-5 py-2.5 h-10"
              @click="DownloadFilteredRecordsExcel()"
            >
              <span>Exportar Excel</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 6.75a.75.75 0 0 1 1.5 0v2.546l.943-1.048a.75.75 0 0 1 1.114 1.004l-2.25 2.5a.75.75 0 0 1-1.114 0l-2.25-2.5a.75.75 0 1 1 1.114-1.004l.943 1.048V8.75Z" clip-rule="evenodd" />
              </svg>
              </Button>
          </div>
          <div class="flex flex-col">
            <Button
              variant="primary"
              size="sm"
              class=" items-center gap-2 max-w-xs text-white font-medium rounded-lg text-sm px-5 py-2.5 h-10"
              @click="DownloadGeneralProviderExcel()"
              disabled
            >
              <span>Exportar PDF</span>
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                <path fill-rule="evenodd" d="M4.5 2A1.5 1.5 0 0 0 3 3.5v13A1.5 1.5 0 0 0 4.5 18h11a1.5 1.5 0 0 0 1.5-1.5V7.621a1.5 1.5 0 0 0-.44-1.06l-4.12-4.122A1.5 1.5 0 0 0 11.378 2H4.5Zm4.75 6.75a.75.75 0 0 1 1.5 0v2.546l.943-1.048a.75.75 0 0 1 1.114 1.004l-2.25 2.5a.75.75 0 0 1-1.114 0l-2.25-2.5a.75.75 0 1 1 1.114-1.004l.943 1.048V8.75Z" clip-rule="evenodd" />
              </svg>
              </Button>
          </div>
        </div>
      </div>

      <div class="my-4 flex flex-col gap-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Campo de selección con su etiqueta -->
          <div class="flex flex-col">
            <Label class="mb-2" for="category" value="Filtrar por categorías" />
            <DynamicMultiSelect
              v-model="filters.category"
              :options="categories"
              placeholder="Selecciona una categoría"
              mode="tags"
              searchable
              class="w-full border p-2 rounded-xl"
            />
          </div>
          <div class="flex flex-col">
            <Label class="mb-2" for="wallet" value="Filtrar por billetera" />
            <DynamicMultiSelect
              v-model="filters.wallet"
              :options="wallets"
              placeholder="Selecciona una billetera"
              mode="tags"
              searchable
              class="w-full border p-2 rounded-xl"
            />
          </div>
          <!-- Campo de fecha con su etiqueta -->
          <div class="flex flex-col">
            <Label class="mb-2" for="date_start" value="Filtrar rango de fecha" />
            <Input
              type="date"
              v-model="filters.date_start"
              class="w-full border p-2 rounded-xl"
              :isRequired="true"
              placeholder="Fecha inicio"
            />
          </div>
          <div class="flex flex-col">
            <Label class="mb-2" for="date_end" value="Fecha final" />
            <Input
              type="date"
              v-model="filters.date_end"
              class="w-full border p-2 rounded-xl"
              :isRequired="true"
              placeholder="Fecha finalización"
            />
          </div>
          
        </div>
      </div>

      <table v-if="programRecords.length > 0" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              id
            </th>
            <th scope="col" class="px-6 py-3">
              Dia programado
            </th>
            <th scope="col" class="px-6 py-3">
              Billetera
            </th>
            <th scope="col" class="px-6 py-3">
              Monto
            </th>
            <th scope="col" class="px-6 py-3">
              Descripcion
            </th>
            <th scope="col" class="px-6 py-3">
              Categoria
            </th>
            <th scope="col" class="px-6 py-3">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>
          <!-- Utiliza v-for para iterar sobre los programRecords -->
          <tr v-for="(programRecord, index) in programRecords" :key="index"
              :class="{
                'bg-green-100 dark:bg-green-800': programRecord.record.type === 'income',
                'bg-red-100 dark:bg-red-800': programRecord.record.type === 'expense',
                'bg-white dark:bg-gray-800': programRecord.record.type !== 'income' && programRecord.record.type !== 'expense'
              }"
              class="border-b dark:border-gray-700"
          >
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ programRecord.id }}
            </th>
            <td class="px-6 py-4">
              {{ programRecord.next_execution }}
            </td>
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ programRecord.record.wallet.name }}
            </th>
            <td class="px-6 py-4">
              ${{ programRecord.record.amount }}
            </td>
            <td class="px-6 py-4">
              {{ programRecord.record.description || 'Sin Descripcion'}}
            </td>
            <td class="px-6 py-4">
              {{ programRecord.record.category.name }}
            </td>
            <td class="px-6 py-4 flex space-x-4"> 
              <PencilAltIcon class="w-5 h-5 text-blue-500 cursor-pointer" @click.stop="openCreateCategoryModal(programRecord)" title="Editar tarea" />
              <TrashIcon class="w-5 h-5 text-red-500 cursor-pointer" @click.stop="deleteProgramRecord(programRecord)" title="Eliminar tarea" />
            </td>

          </tr>

        </tbody>
      </table>

      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Nombre de billetera
            </th>
            <th scope="col" class="px-6 py-3">
              Monto
            </th>
            <th scope="col" class="px-6 py-3">
              Descripcion
            </th>
            <th scope="col" class="px-6 py-3">
              Categoria
            </th>
            <th scope="col" class="px-6 py-3">
              Fecha
            </th>
            <th scope="col" class="px-6 py-3">
              Imagen
            </th>
            <th scope="col" class="px-6 py-3">
              Acciones
            </th>
          </tr>
        </thead>
        <tbody>
          <!-- Utiliza v-for para iterar sobre los registros -->
          <tr v-for="(registro, index) in filteredRegisters" :key="index"
            :class="{
              'bg-green-100 dark:bg-green-800': registro.type === 'income', // Color verdoso para ingresos
              'bg-red-100 dark:bg-red-800': registro.type === 'expense',   // Color rojizo para gastos
              'bg-white dark:bg-gray-800': registro.type !== 'income' && registro.type !== 'expense' // Default
            }"
            class="border-b dark:border-gray-700"
          >
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ registro.wallet.name }}
            </th>
            <td class="px-6 py-4">
              ${{ registro.amount }}
            </td>
            <td class="px-6 py-4">
              {{ registro.description || 'Sin Descripcion'}}
            </td>
            <td class="px-6 py-4">
              {{ registro.category.name }}
            </td>
            <td class="px-6 py-4">
              {{ registro.date }}
            </td>
            <td class="px-6 py-4">
             <div v-if="registro.document" class="cursor-pointer">
                <img
                  :src="`/storage/${registro.document}`"
                  alt="Miniatura"
                  class="w-20 h-auto rounded shadow"
                  @click="openImageModal(`/storage/${registro.document}`)"
                />
              </div>
              <div v-else>
                N/A
              </div>
            </td>
            <td class="px-6 py-4">
              <TrashIcon class="w-5 h-5 text-red-500 cursor-pointer" @click.stop="deleteRecord(registro)" title="Eliminar tarea" />
            </td>
          </tr>

        </tbody>
      </table>
    </div>

    <div v-if="showModalImage" class="fixed inset-0 z-50 bg-black bg-opacity-75 flex items-center justify-center">
      <div class="relative">
        <img :src="modalImageUrl" alt="Imagen grande" class="max-w-full max-h-screen" />
        <button @click="showModalImage = false" class="absolute top-2 right-2 text-white text-2xl">×</button>
      </div>
    </div>

    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Actualizar registro programado</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir una nueva categoría.</p>
          <form @submit.prevent="CreateCategory" class="max-w-md mx-auto mt-8">
            <div class="mb-4 ">
              <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Dia programado</label>
              <input type="text" v-model="editProgramRecord.DOTM" class="w-full border p-2 rounded-xl" />
            </div>
            <div class="mb-4 ">
              <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Wallet</label>
              <select v-model="editProgramRecord.id_wallet" class="w-full border p-2 rounded-xl">
                <option value="" disabled selected>Selecciona una opción</option>
                <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
                  {{ wallet.name }}
                </option>
              </select>
            </div>
            <div class="mb-4 ">
              <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Monto</label>
              <input type="text" v-model="editProgramRecord.amount" class="w-full border p-2 rounded-xl" />
            </div>
            <div class="mb-4 ">
              <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Descripcion</label>
              <input type="text" v-model="editProgramRecord.description" class="w-full border p-2 rounded-xl" />
            </div>
            <div class="mb-4">
              <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Tipo de registro</label>
              <select v-model="editProgramRecord.type" class="w-full border p-2 rounded-xl">
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="income">Ingreso +</option>
                <option value="expense">Gasto -</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Categoria</label>
              <select v-model="editProgramRecord.category.id" @change="handleCategoryChange" class="w-full border p-2 rounded-xl">
                <option value="" disabled selected>Selecciona Categoría</option>
                <option v-for="category in filteredCategories" :key="category.id" :value="category.id">
                  {{ category.name }}
                </option>
                <option value="create">+ Crear nueva categoria</option>
              </select>
            </div>

            <Button
                type="submit"
                class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl mb-4"
                size="base"
                @click="SendEditProgramRecord(editProgramRecord)"
                :disabled="false"
              >
                Actualizar
            </Button>
          </form>
        <div class="mt-6 flex justify-end">
          <Button class="hover:bg-red-500 bg-red-600 text-white p-3 rounded-xl mb-4" @click="closeModal">Cancelar</Button>
        </div>
      </div>
    </Modal>
  </template>
  