<script>
    import Button from '@/Components/Button.vue'

  export default {
    props: {
      categories: Array,
    },
    data() {
      return {
        formData: {
          category: "",
          amount: "",
          description: "",
          date: new Date().toISOString().slice(0, 10), // Establecer la fecha actual
        },
      };
    },
    methods: {
        async enviarFormulario() {
            const requestData = {
                formData: this.formData,
            };
            const response = await this.$inertia.post('expense',requestData);
        },
    },
  };
  </script>
<template>
    <form @submit.prevent="enviarFormulario" class="max-w-md mx-auto mt-8">
      <div class="mb-4">
        <label for="category" class="block text-gray-700 text-sm font-bold mb-2 ">Categoría</label>
        <select v-model="formData.category" class="w-full border p-2 rounded-xl">
          <option value="" disabled selected>Selecciona Categoría</option>
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
      </div>
  
      <div class="mb-4 ">
        <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Cantidad</label>
        <input type="number" v-model="formData.amount" class="w-full border p-2 rounded-xl" />
      </div>
  
      <div class="mb-4">
        <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Fecha</label>
        <input type="date" v-model="formData.date" class="w-full border p-2 rounded-xl"/>
      </div>
  
      <div class="mb-4">
        <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Descripción</label>
        <textarea v-model="formData.description" class="w-full border p-2 rounded-xl"></textarea>
      </div>
        <Button
            type="submit"
            class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl mb-4"
            size="base"
            @click="enviarFormulario"
            :disabled="false"
          >
            Ingresar Gasto
        </Button>
    </form>
  </template>