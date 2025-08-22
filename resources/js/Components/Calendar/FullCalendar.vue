<template>
  <div class="calendar-container">
    <FullCalendar :options="calendarOptions" ref="fullCalendarRef" />
    <ShowOrderModal :orderSelected="orderSelected" :showDetails="showDetails" @close="closeModal"/>
    
  </div>
</template>
<script setup>
import { computed, reactive, watch, ref  } from 'vue';
import FullCalendar from '@fullcalendar/vue3';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import interactionPlugin from '@fullcalendar/interaction';
import ShowOrderModal from '../Modals/ShowOrderModal.vue';

const props = defineProps({
  initialEvents: {
    type: Array,
    default: () => []
  },
  orders: {
    type: Array,
    default: () => []
  }
});

    const showDetails = ref(false)
    const orderSelected = ref(null)

// --- FUNCIONES DE UTILIDAD ---
// Función para asegurar que las fechas estén en formato ISO 8601 (YYYY-MM-DDTHH:mm:ss)
const formatToISO = (dateString) => {
  if (!dateString) return null;
  // Intenta crear un objeto Date. Maneja tanto 'YYYY-MM-DD HH:mm:ss' como 'YYYY-MM-DDTHH:mm:ss.000000Z'
  const date = new Date(dateString);
  if (isNaN(date.getTime())) {
    console.warn(`Fecha inválida para FullCalendar: ${dateString}`);
    return null; // Retorna null si la fecha no es válida
  }
  return date.toISOString().slice(0, 19); // Retorna hasta los segundos, sin milisegundos ni 'Z'
};

const transformedEvents = computed(() => {
  return props.orders.map(order => {
    // 1. Título del Evento
    let title = `Orden #${order.id}`; // Título base: ID de la orden
    if (order.order_details && order.order_details.length > 0) {
      const productTitles = order.order_details
        .map(detail => `Prod: ${detail.product.name}`)
        .join(', ');
      title = `Orden #${order.id}: ${productTitles}`;
    } else {
      title = `Orden #${order.id}: Sin productos`; // Si no hay order_details
    }

    // 2. Fecha de Inicio (start)
    // Prioriza delivery_date, sino order_date
    let eventStartDate = null;
    if (order.order_deliveries.length && order.order_deliveries[0].delivery_date) {
      eventStartDate = order.order_deliveries[0].delivery_date;
    } else if (order.order_date) {
      eventStartDate = order.order_date;
    }

    const formattedStart = formatToISO(eventStartDate);

    // 3. Propiedades adicionales para FullCalendar
    return {
      id: order.id,
      title: title,
      start: formattedStart,
      // end: (Opcional, si tienes una fecha de fin para las entregas)
      // allDay: false, // Las órdenes suelen tener hora específica
      // color: (Opcional, puedes asignar color basado en el estado de la orden)
      color: order.id_state === 1 ? '#4682B4' : '#2ECC71', // Ejemplo: Azul para estado 1, Verde para otros

      // Guardar la orden original en extendedProps para acceso posterior
      extendedProps: {
        originalOrder: order
      }
    };
  }).filter(event => event.start !== null); // Filtra eventos sin fecha de inicio válida
});

// --- REFERENCIA DE PLANTILLA para FullCalendar ---
const fullCalendarRef = ref(null);

// --- CONFIG DEL CALENDARIO ---
const calendarOptions = reactive({
    plugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
    initialView: 'dayGridMonth',
    headerToolbar: {
        left: 'prev,next prevYear today',
        center: 'title',
        right: 'nextYear dayGridMonth,timeGridWeek,timeGridDay'
    },
    locale: 'es',
    firstDay: 1,
    editable: false,
    selectable: true,
    events: transformedEvents.value,
    // Callbacks
    dateClick: handleDateClick,
    eventClick: handleEventClick,
    // eventDrop: handleEventDrop,
    eventResize: handleEventResize,
});



// Watch para reaccionar a cambios en la prop
watch(() => props.initialEvents, (newEvents) => {
  calendarOptions.events = [...newEvents, ...dummyEvents];
}, { deep: true });

watch(() => props.orders, (newEvents) => {
  calendarOptions.events = [...newEvents, ...dummyEvents];
}, { deep: true });

// --- MANEJO DE EVENTOS ---
// ¡MODIFICACIÓN AQUÍ!
function handleDateClick(arg) {
  console.log('¡Clic en la fecha!', arg.dateStr);

  // Acceder a la instancia del calendario a través de la referencia
  const calendarApi = fullCalendarRef.value.getApi();

  // Cambiar la vista a 'timeGridDay' (o 'dayGridDay' para solo el día completo)
  // y establecer la fecha a la que se le hizo clic
  if (calendarApi) {
    calendarApi.changeView('timeGridDay', arg.dateStr); // Puedes usar 'dayGridDay' si prefieres sin horas
  }
}

function handleEventClick(clickInfo) {
    console.log('¡Clic en el evento!', clickInfo.event.id);
    orderSelected.value = clickInfo.event.extendedProps.originalOrder;
    console.log('Orden original:', orderSelected.value);
    showDetails.value = true;
}

// function handleEventDrop(info) {
//   console.log('Evento arrastrado:', info.event.title, 'a', info.event.startStr);
// }

function handleEventResize(info) {
  console.log('Evento redimensionado:', info.event.title, 'de', info.oldEvent.endStr, 'a', info.event.endStr);
}


const ShowOrderDetails = (order) => {
    showDetails.value = true;
    orderSelected.value = order;
};

const closeModal = () => {
    showDetails.value = false;
    orderSelected.value = null;
};
</script>
