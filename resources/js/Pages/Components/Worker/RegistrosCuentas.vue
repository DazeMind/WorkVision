<script setup>
    import Button from '@/Components/Button.vue'
</script>
<script>
  export default {
    props: {
        registros: Array,
    },
    data() {
      return {
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
        async enviarFormulario() {
            const requestData = {
                formData: this.formData,
            };
            const response = await this.$inertia.post('wallet',requestData);
        },
    },
  };
</script>

<template>
    <div class="relative overflow-x-auto mt-5">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">
              Nombre de billetera
            </th>
            <th scope="col" class="px-6 py-3">
              Fecha
            </th>
            <th scope="col" class="px-6 py-3">
              Descripcion
            </th>
            <th scope="col" class="px-6 py-3">
              Categoria
            </th>
            <th scope="col" class="px-6 py-3">
              Monto
            </th>
          </tr>
        </thead>
        <tbody>
          <!-- Utiliza v-for para iterar sobre los registros -->
          <tr v-for="(registro, index) in registros" :key="index" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
              {{ registro.walletTypes }}
            </th>
            <td class="px-6 py-4">
              {{ registro.date }}
            </td>
            <td class="px-6 py-4">
              {{ registro.description }}
            </td>
            <td class="px-6 py-4">
              {{ registro.category }}
            </td>
            <td class="px-6 py-4">
              {{ registro.amount }}
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>
  