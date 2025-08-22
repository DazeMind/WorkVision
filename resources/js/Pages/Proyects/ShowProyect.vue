<template>
    <AuthenticatedLayout title="Workers">
      <template #header>
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h2 
            class="text-lg sm:text-sm md:text-xl font-semibold leading-tight flex items-center space-x-2">
            <span>Mis Proyectos</span>
            <ChevronRightIcon class="w-5 h-5" />
            <span>Gestionar Proyecto</span>
            <ChevronRightIcon class="w-5 h-5" />
            <span>{{ project.name }}</span>
          </h2>
        </div>
      </template>
      
      <div class="flex flex-wrap">
        <div class="w-1/2 sm:w-1/2 lg:w-1/4 p-2">
          <div class="bg-green-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
              <div>
                <h3 class="text-2xl sm:text-xl md:text-2xl lg:text-4xl font-bold">{{tasks.filter(task => task.id_state == 1).length}}</h3>
                <p class="text-sm sm:text-base lg:text-lg">Tareas Terminadas</p>
              </div>
              <PresentationChartBarIcon class="w-8 sm:w-10 lg:w-12 h-8 sm:h-10 lg:h-12" />
            </div>
          </div>
        </div>

        <div class="w-1/2 sm:w-1/2 lg:w-1/4 p-2">
          <div class="bg-yellow-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
              <div>
                <h3 class="text-2xl sm:text-xl md:text-2xl lg:text-4xl font-bold">{{tasks.filter(task => task.id_state == 3).length}}</h3>
                <p class="text-sm sm:text-base lg:text-lg">Tareas pendientes</p>
              </div>
              <ClipboardListIcon class="w-8 sm:w-10 lg:w-12 h-8 sm:h-10 lg:h-12" />
            </div>
          </div>
        </div>

        <div class="w-1/2 sm:w-1/2 lg:w-1/4 p-2">
          <div class="bg-red-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
              <div>
                <h3 class="text-2xl sm:text-xl md:text-2xl lg:text-4xl font-bold">{{ tasks.filter(task => task.delayed).length }}</h3>
                <p class="text-sm sm:text-base lg:text-lg">Tareas retrasadas</p>
              </div>
              <CalendarIcon class="w-8 sm:w-10 lg:w-12 h-8 sm:h-10 lg:h-12" />
            </div>
          </div>
        </div>

        <div class="w-1/2 sm:w-1/2 lg:w-1/4 p-2">
          <div class="bg-blue-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
              <div>
                <h3 class="text-2xl sm:text-xl md:text-2xl lg:text-4xl font-bold">{{workers_project.length}}<sup class="text-sm sm:text-base lg:text-xl">%</sup></h3>
                <p class="text-sm sm:text-base lg:text-lg">Asistencia</p>
              </div>
              <UserGroupIcon class="w-8 sm:w-10 lg:w-12 h-8 sm:h-10 lg:h-12" />
            </div>
          </div>
        </div>
      </div>

      <!-- <CardsDashBoard /> -->

      <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="gestiontareas">
        <div class="relative overflow-x-auto">
          <div id="Gestion TAREAS">
            <TodoListTask :tasks="tasks" :proyectId="project.id" :workers_project="workers_project" :taskpriorities="taskpriorities" />
          </div>
        </div>
      </div>
      <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="workerproyect">
        <div class="relative overflow-x-auto">
          <div id="Gestion Workers">
            <WorkersProyect :workers_project="workers_project" :allWorkers="allWorkers" :proyectId="project.id"/>
          </div>
          <!--<div id="Gestion GASTOS">
            <p>Seguridad y otros</p>
          </div> -->
        </div>
      </div>

      <!-- <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <div class="relative overflow-x-auto">
          <div id="Gestion Archivos">
            <ListDocuments :projectFiles="projectFiles"/>
          </div>
        </div>
      </div> -->




      <!-- <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <div class="relative overflow-x-auto">
          <div id="Gestion gastos">
            <GestionBalance/>
          </div>
        </div>
      </div> -->
    </AuthenticatedLayout>
  </template>
  
  <script setup>
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import FormCreateProyect from '../Components/Proyect/FormProyect.vue';
    import CardsDashBoard from '../Components/CardsDashBoard.vue';
    import TodoListTask from './Tasks/TodoListTask.vue';
    import WorkersProyect from './Workers/WorkersProyect.vue';
    import { ChevronRightIcon } from '@heroicons/vue/solid';
    import { CalendarIcon, ClipboardListIcon, ClockIcon, PencilAltIcon, PlusCircleIcon, PresentationChartBarIcon, TrashIcon, } from '@heroicons/vue/solid';
    import { TrendingDownIcon, UserGroupIcon } from '@heroicons/vue/outline';
    import ListDocuments from './FilesProjects/ListDocuments.vue';

  </script>
  
  <script>
  export default {
    data() {
      return {
        today:""
      };
    },
    methods: {
        getBadgeClass(priority) {
            switch (priority) {
                case 'danger':
                return 'text-red-500';
                case 'info':
                return 'text-blue-500';
                case 'warning':
                return 'text-yellow-500';
                case 'primary':
                return 'text-indigo-500';
                case 'secondary':
                return 'text-gray-500';
                default:
                return 'text-gray-500';
            }
        },
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
        CardsDashBoard,
        TodoListTask,
        WorkersProyect
    },
    props: {
      companies: Array,
      project: Object,
      user: Object,
      allWorkers:Array,
      workers_project: Array,
      tasks: Array,
      taskpriorities: Array,
       projectFiles: {
        type: Array,
        required: false,
        default: () => ([
        {
            id: 1,
            file_name: 'Contrato_Cliente_A.pdf',
            file_path: '/storage/proyectos/contratos/Contrato_Cliente_A.pdf',
            file_type: 'contrato',
            uploaded_by: 2,
            uploaded_at: '2025-05-18',
        },
        {
            id: 2,
            file_name: 'Plano_Estructura_01.dwg',
            file_path: '/storage/proyectos/planos/Plano_Estructura_01.dwg',
            file_type: 'plano',
            uploaded_by: 2,
            uploaded_at: '2025-05-17',
        },
        {
            id: 3,
            file_name: 'Presupuesto_Inicial.xlsx',
            file_path: '/storage/proyectos/presupuestos/Presupuesto_Inicial.xlsx',
            file_type: 'presupuesto',
            uploaded_by: 1,
            uploaded_at: '2025-05-10',
        },
        {
            id: 4,
            file_name: 'Notas_Varias.txt',
            file_path: '/storage/proyectos/otros/Notas_Varias.txt',
            file_type: 'otro',
            uploaded_by: 3,
            uploaded_at: '2025-05-12',
        }
        ])
    }
      
    },
    mounted() {
      const currentDate = new Date();
      this.today  = currentDate.toISOString().split('T')[0];
      this.tasks.forEach(task => {
        const taskDate = new Date(task.date); 
        task.delayed = taskDate < new Date(this.today);
      });
    },
  };
  </script>