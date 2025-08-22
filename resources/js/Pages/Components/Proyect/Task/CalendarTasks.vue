<template>
    <div>
      <h2 class="text-lg font-bold mb-4">Calendario de Tareas</h2>
      <div style="width: 100%; height: 600px;">
        <FullCalendar
          :events="events"
          :plugins="[dayGridPlugin, interactionPlugin]"
          initial-view="dayGridMonth"
          @dateClick="handleDateClick"
        />
      </div>
    </div>
  </template>
  
  <script>
  import { ref, computed } from 'vue';
  
  // Importar los plugins correctos de FullCalendar
  import FullCalendar from '@fullcalendar/vue3'; 
  import dayGridPlugin from '@fullcalendar/daygrid'; // Vista de cuadrícula de días
  import interactionPlugin from '@fullcalendar/interaction'; // Interacciones como clic en las fechas
  
  export default {
    props: {
      tasks: {
        type: Array,
        required: true,
      },
    },
    components: {
      FullCalendar,
    },
    setup(props) {
      // Mapeo de tareas a eventos
      const events = computed(() => {
        return props.tasks.map(task => ({
          title: task.title,
          start: task.date,
        }));
      });
  
      // Manejo del clic sobre una fecha
      const handleDateClick = (info) => {
        alert(`Fecha seleccionada: ${info.dateStr}`);
      };
  
      return {
        events,
        handleDateClick,
      };
    },
  };
  </script>
  