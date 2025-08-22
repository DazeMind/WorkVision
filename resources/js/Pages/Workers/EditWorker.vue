<template>
    <AuthenticatedLayout title="Worker edit">
      <template #header>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h2 class="text-xl font-semibold leading-tight">
            Gestor de Colaboradores
          </h2>
        </div>
      </template>

      <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <p class="text-lg font-semibold leading-tight mb-3">
            Mis Colaboradores
        </p>
        <div class="relative overflow-x-auto">
          <FormCreateWorker :worker="worker" :companies="companies"/>
        </div>
      </div>

    
  
    </AuthenticatedLayout>
  </template>
  
  <script setup>
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import FormCreateWorker from '../Components/Worker/FormCreateWorker.vue';
  </script>
  
  <script>
    export default {
      data() {
          return {
              //
          };
      },
      methods: {
          //
      },
      components: {
        FormCreateWorker
      },
      props: {
          worker:Object,
          companies:Object,
      },
      computed: {
          //
      },
      mounted() {
          // console.log("Workers");
          // console.log(this.worker);
      },
    };
  </script>