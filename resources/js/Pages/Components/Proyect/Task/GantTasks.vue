<template>
    <div>
      <h2 class="text-lg font-bold mb-4">Carta Gantt de Tareas</h2>
      <div ref="timeline" style="height: 300px; border: 1px solid red;"></div>
    </div>
  </template>
  
  <script>
  import { ref, onMounted, nextTick } from 'vue';
  import { Timeline } from 'vis-timeline/standalone';
  import 'vis-timeline/styles/vis-timeline-graph2d.css';

export default {
  setup() {
    const tasks = ref([
      { id: 1, title: 'Tarea 1', start: '2024-12-01', end: '2024-12-08' },
      { id: 2, title: 'Tarea 2', start: '2024-12-09', end: '2024-12-15' },
      { id: 3, title: 'Tarea 3', start: '2024-12-16', end: '2024-12-20' },
    ]);

    const timelineContainer = ref(null);

    onMounted(async () => {
      // Asegúrate de que el DOM se haya actualizado antes de crear la línea de tiempo
      await nextTick();
      createTimeline();
    });

    const createTimeline = () => {
    const container = timelineContainer.value;
        if (container) {
            const items = tasks.value.map(task => ({
            id: task.id,
            content: task.title,
            start: task.start,
            end: task.end,
            }));

            console.log(items); // Verifica que los datos sean correctos

            const options = {
            editable: false,
            stack: false,
            start: '2024-12-01',
            end: '2024-12-31',
            margin: { item: 10 },
            };

            new Timeline(container, items, options);
        }
    };


    return {
      timelineContainer,
    };
  },
};
  </script>
  
  