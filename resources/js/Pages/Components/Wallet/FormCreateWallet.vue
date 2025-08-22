<script setup>
    import Button from '@/Components/Button.vue'

</script>
<script>
  export default {
    props: {
      walletTypes: Array,
      wallets: Array,
    },
    data() {
      return {
        formData: {
          walletTypes:  "",
          name:  "",
          amount:  "",
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

            console.log(requestData);
            const response = await this.$inertia.post('wallet',requestData);
            console.log(response);
            this.$emit('formulario-enviado');
        },
    },
    mounted() {
      // Este código se ejecuta después de que el componente se monte en el DOM
      console.log('wallet', this.wallets[0]);
    },
  };
  </script>


<template>
    <form @submit.prevent="enviarFormulario" class="max-w-full p-8">
      <h1 class="mb-4 text-xl font-bold">Crear billetera</h1>

      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
          <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Tipo de billetera</label>
          <select v-model="formData.walletTypes" class="w-full border p-2 rounded-xl" required>
            <option value="" disabled selected>Selecciona Categoría</option>
            <option v-for="category in walletTypes" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <div class="mb-4">
          <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nombre de la billetera</label>
          <input type="text" v-model="formData.name" class="w-full border p-2 rounded-xl" required minlength="3" />
        </div>
      </div>

      <!-- Campo condicional: Número de cuenta -->
      <div v-if="formData.walletTypes !== 1 && formData.walletTypes !== 2 && formData.walletTypes != null" class="mb-4">
        <label for="numberAccount" class="block text-gray-700 text-sm font-bold mb-2">Número de cuenta</label>
        <input type="text" v-model="formData.numberAccount" class="w-full border p-2 rounded-xl" />
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div class="mb-4">
          <label for="amount" class="block text-gray-700 text-sm font-bold mb-2">Monto inicial</label>
          <input type="number" v-model="formData.amount" class="w-full border p-2 rounded-xl" required />
        </div>

        <div class="mb-4 w-1/6">
          <label for="color" class="block text-gray-700 text-sm font-bold mb-2">Seleccione un color</label>
          <div :style="{ backgroundColor: formData.color }" class="h-8 w-8 rounded-md border">
            <input type="color" v-model="formData.color" class="w-full border p-2 rounded-xl" style="opacity: 0;" required />
          </div>
        </div>
      </div>

      <Button
        type="submit"
        class="hover:bg-blue-500 bg-blue-600 text-white p-3 rounded-xl w-full"
        size="base"
        @click="enviarFormulario"
        :disabled="false"
      >
        Registrar billetera
      </Button>
    </form>

  </template>