<template>
  <AuthenticatedLayout title="Workers">
    <template #header>
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold leading-tight">
          Gestor de ventas y ordenes 
        </h2>
      </div>
    </template>

    <div class="p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1">
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-6 gap-4">
        <Button
          external
          variant="black"
          class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
          href=""
          @click=""
          disabled
        >
          <DownloadIcon class="w-5 h-5 mr-2" />
          Exportar Balance
        </Button>
        <Button
          external
          variant="black"
          class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
          href=""
          @click=""
          disabled
        >
          <DownloadIcon class="w-5 h-5 mr-2" />
          Exportar Ventas/Ordenes
        </Button>
        <Button
          external
          variant="black"
          class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
          href=""
          @click=""
          disabled
        >
          <DownloadIcon class="w-5 h-5 mr-2" />
          Exportar General
        </Button>
        <Button
          external
          variant="black"
          class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
          href=""
          @click=""
          disabled
        >
          <DownloadIcon class="w-5 h-5 mr-2" />
          Crear Proyecto
        </Button>
      </div>
      <Button
          external
          variant="black"
          class="flex items-center gap-2 w-full mt-5 sm:w-auto max-w-xs bg-blue-700"
          href=""
          @click="OpenModalFormCreateSaleStep1"
        >
          Ingresar Pedido / Venta
      </Button>
    </div>

    <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5">
      <TableOrderSales :OrderStates="OrderStates" :companies="companies" :user="user" />
    </div>
    <Modal :show="showModalFormCreateSaleStep1" @close="closeModal">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear nueva Venta</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir una agregar una nueva venta.</p>
        <FormCreateSaleStep1 @closeModalCreateSale="closeModal" :OrderStates="OrderStates" :wallets="wallets" :consumers="consumers" :productServices="productServices" :companies="companies" :regions="regions" :provinces="provinces" :comunes="comunes"/>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModal">Cancelar</Button>
        </div>
      </div>
    </Modal>
  </AuthenticatedLayout>
</template>
  
  <script setup>
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import Button from '@/Components/Button.vue';
    import { DownloadIcon } from '@heroicons/vue/solid';
    import TableOrderSales from '../Components/OrderSales/TableOrderSales.vue';
    import Modal from '@/Components/Modal.vue';
    import FormCreateSaleStep1 from '../Components/OrderSales/FormCreateSaleStep1.vue';
    import { ref } from 'vue'

    defineProps({
      companies: Array,
      consumers: Array,
      productServices: Array,
      user: Object,
      regions:Array,
      provinces:Array,
      comunes:Array,
      wallets:Array,
      OrderStates:Array,
    })

    const showModalFormCreateSaleStep1 = ref(false)

    //Methods
    const OpenModalFormCreateSaleStep1 = () => {
      showModalFormCreateSaleStep1.value = true;
    };

    const closeModal = () => {
      showModalFormCreateSaleStep1.value = false;
    };

    const ShowOrderSale = (projectId) => {
      this.$inertia.visit(route('proyect.show', { id: projectId }));
    };

    const updateOrderSale = (projectId) => {
      this.$inertia.visit(route('proyect.edit', { id: projectId }));
    };


    const deleteOrderSale = (project) => {
      if (confirm(`¿Estás seguro de que quieres eliminar el proyecto ${project.name}?`)) {
        this.$inertia.delete(route('proyect.destroy', { id: project.id })).then(() => {
          this.$inertia.visit(route('proyect'));
        }).catch(error => {
          console.error('Error al eliminar colaborador:', error);
        });
      }
    };
  </script>