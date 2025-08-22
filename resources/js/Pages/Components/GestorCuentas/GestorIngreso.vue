<script>
  import Button from '@/Components/Button.vue';
  import { ref, nextTick } from "vue";
  import Modal from "@/Components/Modal.vue";

  export default {
    components:{
      Button,
      Modal,
    },
    props: {
      categories: Array,
      wallets: Array,
    },
    data() {
      return {
        filteredCategories:[],
        showModal: false,
        isScheduled :false,
        form:{
          name:"",
          type:"",
        },
        formData: {
          wallet: "" ,
          type: "",
          category: "",
          amount: "",
          description: "",
          file: "",
          day: "",
          date: new Date().toISOString().slice(0, 10), // Establecer la fecha actual
        },
      };
    },
    methods: {
      handleCategoryChange(event) {
        // Siempre abrir modal si se selecciona "create"
        if (event.target.value === "create") {
          this.openCreateCategoryModal();
          this.formData.category = "";
        }
      },
      openCreateCategoryModal() {
        this.showModal = true;
        nextTick(() => {
          console.log("Modal abierto");
        });
      },
      closeModal() {
        this.showModal = false;
      },
      handleFileChange(event) {
        const file = event.target.files[0];
        if (file) {
          console.log("Archivo seleccionado:", file);
        } else {
          console.warn("No se seleccionó ningún archivo.");
        }
        this.formData.file = file;
      },
      async enviarFormulario() {
        const formData = new FormData();
        formData.append("wallet", this.formData.wallet);
        formData.append("type", this.formData.type);
        formData.append("category", this.formData.category);
        formData.append("amount", this.formData.amount);
        formData.append("description", this.formData.description);
        formData.append("date", this.formData.date);
        formData.append("day", this.formData.day);
        if (this.formData.file) {
          formData.append("file", this.formData.file);
        } else {
          console.warn("No se seleccionó ningún archivo.");
        }
        try {
          console.log("file",this.formData.file);
          const response = await this.$inertia.post("incomeExpense/store", formData, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          });         

        } catch (error) {
          console.error("Error al enviar el formulario:", error);
        }
      },
      async CreateCategory() {
        const form = new FormData();
        form.append("name", this.form.name);
        form.append("type", this.form.type);

        try {
          const response = await this.$inertia.post("category", form, {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }); 
        } catch (error) {
          console.error("Error al enviar el formulario:", error);
        }
        window.location.reload();
                
      },
      filterCategories() {
        if (this.formData.type !== null) {
          this.filteredCategories = this.categories.filter(category => String(category.type) === String(this.formData.type));
        }        
      }
    },
    mounted() {
      if (this.wallets.length === 1) {
        this.formData.wallet = this.wallets[0].id;
      }
    },
    watch: {
      'formData.type': function(newType) {
        this.filterCategories(); 
      },
    }
  };
</script>
<template>
  <h1 class="text-bold tex">Agregar registro</h1>
    <form @submit.prevent="enviarFormulario" enctype="multipart/form-data" class="max-w-md mx-8 mt-5" v-if="wallets[0]">
      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
          <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Seleccione tipo de registro</label>
          <select v-model="formData.type" class="w-full border p-2 rounded-xl">
            <option value="" disabled selected>Selecciona una opción</option>
            <option value="1">Ingreso +</option>
            <option value="2">Gasto -</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Seleccione una billetera</label>
          <select v-model="formData.wallet" class="w-full border p-2 rounded-xl">
            <option value="" disabled selected>Selecciona una opción</option>
            <option v-for="wallet in wallets" :key="wallet.id" :value="wallet.id">
              {{ wallet.name }}
            </option>
          </select>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
          <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Categoría</label>
          <select v-model="formData.category" @change="handleCategoryChange" class="w-full border p-2 rounded-xl">
            <option value="" disabled selected>Selecciona Categoría</option>
            <option v-for="category in filteredCategories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
            <option value="create">+ Crear nueva categoria</option>
          </select>
        </div>
        <div class="mb-4">
          <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Monto</label>
          <input type="number" v-model="formData.amount" class="w-full border p-2 rounded-xl" />
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
          <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
          <input type="date" v-model="formData.date" class="w-full border p-2 rounded-xl" />
        </div>

        <div class="mb-4">
          <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
          <textarea v-model="formData.description" class="w-full border p-2 rounded-xl"></textarea>
        </div>
      </div>

      <div class="flex items-center mb-4">
          <input id="default-checkbox" type="checkbox" v-model="isScheduled" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
          <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">¿Quieres programar este registro?</label>

          <div class="mx-4" v-if="isScheduled">
            <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Dia del mes</label>
            <select v-model="formData.day" @change="handleCategoryChange" class="w-full border p-2 rounded-xl">
              <option value="" disabled selected>Selecciona Categoría</option>
              <option v-for="day in 31" :key="day" :value="day">{{ day }}</option>
            </select>
          </div>
        </div>
        
      <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Puedes subir un comprobante de este registro (OPCIONAL)</label>
      <div class="flex items-center justify-center w-full mb-4">
        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
          <div class="flex flex-col items-center justify-center pt-3 pb-4">
            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click para subir</span> o arrastra y suelta</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
          </div>
          <input id="dropzone-file" type="file" class="hidden" @change="handleFileChange" />
        </label>
      </div>

      <Button
        type="submit"
        class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl my-4"
        size="base"
        @click="enviarFormulario"
        :disabled="false"
      >
        Generar {{ formData.type == 1 ? 'Ingreso' : 'Gasto' }}
      </Button>
    </form>
    <div v-else>
      <h1 class="mt-4 text-2xl text-bold text-center">Primero debes crear una billetera</h1>
    </div>
    <Modal :show="showModal" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear nueva categoría</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir una nueva categoría.</p>
          <form @submit.prevent="CreateCategory" class="max-w-md mx-auto mt-8">
            <div class="mb-4 ">
              <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Nombre categoria</label>
              <input type="text" v-model="form.name" class="w-full border p-2 rounded-xl" />
            </div>
            <div class="mb-4">
              <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Seleccione tipo de categoria</label>
              <select v-model="form.type" class="w-full border p-2 rounded-xl">
                <option value="" disabled selected>Selecciona una opción</option>
                <option value="1">Ingreso +</option>
                <option value="2">Gasto -</option>
              </select>
            </div>
            <!-- <div class="mb-4">
              <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Icon</label>
              <input type="date" v-model="formData.date" class="w-full border p-2 rounded-xl"/>
            </div>
        
            <div class="mb-4">
              <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Color</label>
              <textarea v-model="formData.description" class="w-full border p-2 rounded-xl"></textarea>
            </div> -->
              <Button
                  type="submit"
                  class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl mb-4"
                  size="base"
                  @click="CreateCategory"
                  :disabled="false"
                >
                  Guardar Categoria
              </Button>
          </form>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModal">Cancelar</Button>
        </div>
      </div>
    </Modal>
  </template>