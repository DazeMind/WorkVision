<template>
    <AuthenticatedLayout title="Workers">
      <template #header>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h2 class="text-xl font-semibold leading-tight">
            Gestor de Proyectos
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
            Exportar Asistencia
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
            @click="toggleFormCreateWorker"
          >
            Crear Proyecto
          </Button>
      </div>
      <div v-if="$page.props.flash.message" class="mt-4 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
        <FlashMessage
            :show="$page.props.flash.message"
            :on-dismiss="() => (showAlert = false)"
            :title="$page.props.flash.title"
            :content="$page.props.flash.content"
            :variant="$page.props.flash.type"
          /> 
      </div>

      <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <p class="text-lg font-semibold leading-tight mb-3">
            Mis Proyectos
        </p>
        <div class="relative overflow-x-auto">
          <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
              <tr>
                <th scope="col" class="px-6 py-3">ACCIONES</th>
                <th scope="col" class="px-6 py-3">ID</th>
                  <th class="px-6 py-3" v-if="user.roles[0].name === 'SuperAdmin'">
                    <span >Empresa</span>
                  </th>    
                <th scope="col" class="px-6 py-3">Nombre Proyecto</th>
                <th scope="col" class="px-6 py-3">Fecha Inicio</th>
                <th scope="col" class="px-6 py-3">Fecha finalizacion</th>
                <th scope="col" class="px-6 py-3">Estado Adicional</th>
                <th scope="col" class="px-6 py-3">Descripción</th>
                <th scope="col" class="px-6 py-3">Estado</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="(company, companyIndex) in companies" :key="companyIndex">
            <!-- Iterar sobre los proyectos de cada compañía -->
            <tr v-for="(project, projectIndex) in company.projects" :key="projectIndex">
                <td class="px-6 py-3">
                  <Button variant="warning" title="Gestionar Proyecto" size="sm" class="items-center gap-2 max-w-xs p-1 ms-1" @click="ShowProject(project.id)">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                          <ChartSquareBarIcon></ChartSquareBarIcon>
                      </svg>
                  </Button>
                  <Button :disabled="true" variant="primary" title="Editar Proyecto" size="sm" class="items-center gap-2 max-w-xs p-1 ms-1" @click="updateProject(project.id)">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                      <PencilIcon></PencilIcon>
                    </svg>
                  </Button>
                  <Button variant="danger" title="Eliminar Proyecto" size="sm" class="items-center gap-2 max-w-xs p-1" @click="deleteProject(project)">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5">
                          <TrashIcon></TrashIcon>
                      </svg>
                  </Button>
                </td>
                <td class="px-6 py-3">{{ project.id }}</td>
                <td v-if="user.roles.some(role => role.name === 'SuperAdmin')" class="px-6 py-3">{{ company.name }}</td>
                <td class="px-6 py-3">{{ project.name }}</td>
                <td class="px-6 py-3">{{ project.start_date }}</td>
                <td class="px-6 py-3">{{ project.end_date }}</td>
                <td class="px-6 py-3">{{ project.status }}</td>
                <td class="px-6 py-3">{{ project.description }}</td>
                <td class="px-6 py-3">{{ project.state.name }}</td>
            </tr>
        </template>
            </tbody>
        </table>
        </div>
      </div>

    
  
    </AuthenticatedLayout>
  </template>
  
  <script setup>
    import { TrashIcon, ChartSquareBarIcon } from '@heroicons/vue/outline'
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import Button from '@/Components/Button.vue';
    import { DownloadIcon, PencilIcon } from '@heroicons/vue/solid';
    import { router } from '@inertiajs/vue3';
    import FlashMessage from '@/Components/FlashMessage.vue';

    const props = defineProps({
      companies: Array,
      user: Object,
    })

    const ShowProject = (projectId) => {
      router.visit(route('proyect.show',{id:projectId}));
    }
    const updateProject = (projectId) => {
      router.visit(route('proyect.edit', { id: projectId }));
    }

    const toggleFormCreateWorker = ()=>{
      router.visit(route('proyect.create'));
    }

    const deleteProject = (project) =>{
      if (confirm(`¿Estás seguro de que quieres eliminar el proyecto ${project.name}?`)) {
        router.delete(route('proyect.destroy', { id: project.id })).then(() => {
          router.visit(route('proyect'));
        }).catch(error => {
          console.error('Error al eliminar colaborador:', error);
        });
      }
    }

    const updateWorker = (worker) => {
        router.visit(route('worker.edit',{id:worker.id}));
    }

  </script>