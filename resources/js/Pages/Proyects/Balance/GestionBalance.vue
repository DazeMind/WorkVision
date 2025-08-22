<template>
    <div class="bg-white shadow-md rounded-lg p-4">
      <!-- Header de la tarjeta -->
      <div class="flex justify-between items-center mb-4 cursor-pointer" @click="toggleCollapse">
        <h3 class="name-lg font-semibold flex items-center">
          <TrendingUpIcon class="w-5 h-5 mr-2" />
          GESTION GASTOS
        </h3>
        
        <!-- Botón para colapsar/expandir -->
        <button class="name-gray-500 hover:name-gray-700">
          <span v-if="isCollapsed">▼</span>
          <span v-else>▲</span>
        </button>
      </div>
  
      <!-- Contenido colapsable -->
      <transition name="fade">
        <div v-if="!isCollapsed">
         <!-- Tabla de trabajadores -->
          <div>
            <h2 class="text-xl font-bold mb-4">Gráfico de Ingresos, Gastos y Saldo</h2>
            <ChartDoughnut
            :labels="chartLabels"
            :data="chartData"
            :backgroundColors="chartBackgroundColors"
            :borderColors="chartBorderColors"
          />          
        </div>
          <!-- <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
              <tr>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  <UserIcon class="w-5 h-5 name-gray-500 inline-block mr-2" />
                  CATEGORIA
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  WALLET
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  MONTO
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  FECHA
                </th>
                <th scope="col" class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                  Acciones
                </th>
              </tr>
            </thead>
            
            <tbody class="bg-white divide-y divide-gray-200">
              <tr
                v-for="(worker, index) in paginatedworkerss"
                :key="index"
                class="hover:bg-gray-50"
              >
                <td class="px-4 py-2 whitespace-nowrap flex items-center">
                  <UserIcon class="w-5 h-5 name-gray-500 mr-2 cursor-move" />
                  <CheckIcon class="w-5 h-5 mr-2" v-if="worker.completed" />
                  <input type="checkbox" v-model="worker.completed" class="mr-2 cursor-pointer" />
                  <span>{{ worker.name }}</span>
                </td>

                <td class="px-4 py-2 whitespace-nowrap">
                  <small :class="getBadgeClass(worker.priority)">
                    <ClockIcon class="w-4 h-4 inline-block mr-1" />
                    {{ worker.date }}
                  </small>
                </td>

                <td class="px-4 py-2 whitespace-nowrap">
                  <small :class="getBadgeClass(worker.priority)">
                    <CalendarIcon class="w-4 h-4 inline-block mr-1" />
                    {{ worker.time }}
                  </small>
                </td>
                <td class="px-4 py-2 whitespace-nowrap">
                  <small :class="getBadgeClass(worker.priority)">
                    date
                  </small>
                </td>

                <td class="px-4 py-2 whitespace-nowrap flex space-x-2">
                  <PencilAltIcon class="w-5 h-5 name-blue-500 cursor-pointer" @click="editworkers(index)" title="Editar trabajador" />
                  <TrashIcon class="w-5 h-5 name-red-500 cursor-pointer" @click="deleteworkers(index)" title="Eliminar trabajador" />
                </td>
              </tr>
            </tbody>
          </table> -->

          <!-- Paginación -->
          <div class="flex justify-center space-x-2 mt-4">
            <button @click="changePage(currentPage - 1)" :disabled="currentPage === 1" class="name-gray-500 hover:name-gray-700">
              «
            </button>
            <button
              v-for="page in totalPages"
              :key="page"
              @click="changePage(page)"
              :class="{'font-bold name-blue-500': currentPage === page, 'name-gray-500': currentPage !== page}"
              class="hover:name-gray-700"
            >
              {{ page }}
            </button>
            <button @click="changePage(currentPage + 1)" :disabled="currentPage === totalPages" class="name-gray-500 hover:name-gray-700">
              »
            </button>
          </div>

          <!-- Botón de marcar asistencia -->
          <!-- <div class="mt-4 flex justify-start">
            <button @click="addworkers" class="bg-blue-500 name-white px-4 py-2 rounded hover:bg-blue-600 flex items-center">
              <ClipboardCheckIcon class="w-5 h-5 mr-2" />
              BOTON
            </button>
          </div> -->

        </div>
      </transition>
    </div>
  </template>
  
  <script setup>
  import ChartDoughnut from '@/Components/Charts/ChartDoughnut.vue';
  import { ref, computed, onMounted, watch } from 'vue';

  // Estado existente
  const isCollapsed = ref(true);
  const currentPage = ref(1);
  const workerssPerPage = ref(5);

  const chartLabels = ['Ingresos', 'Gastos'];
  const chartData = [7100, 1200]; // Ejemplo de datos (puedes ajustar según lo que necesites)
  const chartBackgroundColors = [
    'rgba(75, 192, 192, 0.5)',  // Color de los Ingresos
    'rgba(255, 99, 132, 0.5)',  // Color de los Gastos
  ];
  const chartBorderColors = [
    'rgba(75, 192, 192, 1)',
    'rgba(255, 99, 132, 1)',
  ];
  
  const workerss = ref([
    { name: 'Danny Zepeda', completed: false, priority: 'danger', time: '2 day', date: '12-11-2024' },
    { name: 'Juan Soto baldes', completed: true, priority: 'info', time: '4 hours', date: '10-12-2024' },
    { name: 'Marcelo vargas ', completed: false, priority: 'warning', time: '1 day', date: '12-11-2024' },
    { name: 'Juanito jaun', completed: false, priority: 'primary', time: '1 hours', date: '12-11-2024' },
    { name: 'NOMBRE APELLIDO', completed: false, priority: 'secondary', time: '1 month', date: '12-11-2024' },
    { name: 'JORGE MARCELO', completed: false, priority: 'info', time: '2 days', date: '15-11-2024' },
    { name: 'Maria araos', completed: true, priority: 'warning', time: '1 day', date: '16-11-2024' },
    { name: 'Jessica Ferrada', completed: false, priority: 'danger', time: '3 days', date: '18-11-2024' },
  ]);
  
  const toggleCollapse = () => {
    isCollapsed.value = !isCollapsed.value;
  };
  
  const totalPages = computed(() => Math.ceil(workerss.value.length / workerssPerPage.value));
  
  const paginatedworkerss = computed(() => {
    const start = (currentPage.value - 1) * workerssPerPage.value;
    const end = start + workerssPerPage.value;
    return workerss.value.slice(start, end);
  });
  
  const changePage = (page) => {
    if (page >= 1 && page <= totalPages.value) {
      currentPage.value = page;
    }
  };
  
  
  const editworkers = (index) => {
    alert(`Edit workers: ${workerss.value[index].name}`);
  };
  
  const deleteworkers = (index) => {
    workerss.value.splice(index, 1);
    if (currentPage.value > totalPages.value) {
      currentPage.value = totalPages.value;
    }
  };
  
  const addworkers = () => {
    workerss.value.push({ name: 'New workers', completed: false, priority: 'primary', time: 'Just now' });
  };
   
  let chartInstance = null;

  onMounted(() => {
    if (!chartRef.value) return;
    const ctx = chartRef.value.getContext('2d');
    chartInstance = new Chart(ctx, {
      type: 'doughnut',
      data,
      options,
    });
  });

  watch(() => isCollapsed.value, (newValue) => {
    if (!newValue && chartRef.value) {
      if (chartInstance) {
        chartInstance.destroy();
      }
      const ctx = chartRef.value.getContext('2d');
      chartInstance = new Chart(ctx, {
        type: 'doughnut',
        data,
        options,
      });
    }
  });

  </script>
  
  <style scoped>
  canvas {
    max-width: 100%;
    margin: auto;
  }

  .fade-enter-active,
  .fade-leave-active {
    transition: opacity 0.3s;
  }
  .fade-enter-from,
  .fade-leave-to {
    opacity: 0;
  }
  </style>
  