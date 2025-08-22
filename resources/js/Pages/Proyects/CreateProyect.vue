<template>
    <AuthenticatedLayout title="Workers">
      <template #header>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h2 class="text-xl font-semibold leading-tight">
            Crear Proyecto
          </h2>
        </div>
      </template>

      <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <div class="relative overflow-x-auto">
          <FormCreateProyect :companies="companies" :states="states"/>
        </div>
      </div>
    </AuthenticatedLayout>
  </template>
  
  <script setup>
    import { TrashIcon } from '@heroicons/vue/outline'
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import FormCreateProyect from '../Components/Proyect/FormProyect.vue';
  </script>
  
  <script>
  export default {
    data() {
      return {
        //
      };
    },
    methods: {
      toggleFormCreateWorker() {
        this.$inertia.visit(route('proyect.create'));
      },
      deleteWorker(worker){
        if (confirm(`¿Estás seguro de que quieres eliminar a ${worker.first_name} ${worker.first_last_name}?`)) {
          this.$inertia.delete(route('worker.destroy', { id: worker.id })).then(() => {
            this.$inertia.visit(route('worker'));
          }).catch(error => {
            console.error('Error al eliminar colaborador:', error);
          });
        }
      },
      updateWorker(worker){
        this.$inertia.visit(route('worker.edit',{id:worker.id}));
      }
    },
    components: {
        FormCreateProyect,
        TrashIcon,
    },
    props: {
      companies: Array,
      user: Object,
      states: Array,
    },
    computed: {
      //
    },
    mounted() {
      // console.log("Workers recibidos:", this.companies);
    },
  };
  </script>