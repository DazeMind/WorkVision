<template>
    <div>
        <canvas ref="chartRef"></canvas>
    </div>
</template>
  
<script setup>
  import { ref, onMounted, watch } from 'vue';
  import { Chart, registerables } from 'chart.js';  
  
  Chart.register(...registerables);
  
  const props = defineProps({
    labels: {
      type: Array,
      required: true,
    },
    data: {
      type: Array,
      required: true,
    },
    backgroundColors: {
      type: Array,
      required: true,
    },
    borderColors: {
      type: Array,
      required: true,
    },
  });
  
  const chartRef = ref(null);
  let chartInstance = null;
  
  onMounted(() => {
    if (!chartRef.value) return;
    const ctx = chartRef.value.getContext('2d');
    chartInstance = new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: props.labels,
        datasets: [
          {
            label: 'Balance Financiero',
            data: props.data,
            backgroundColor: props.backgroundColors,
            borderColor: props.borderColors,
            borderWidth: 1,
          },
        ],
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top',
          },
          tooltip: {
            callbacks: {
              label: (tooltipItem) => {
                return `${tooltipItem.label}: $${tooltipItem.raw}`;
              },
            },
          },
        },
      },
    });
  });
  
  watch(() => props.data, (newData) => {
    if (chartInstance) {
      chartInstance.data.datasets[0].data = newData;
      chartInstance.update();
    }
  });
</script>
  
<style scoped>
  canvas {
    max-width: 100%;
    margin: auto;
  }
</style>
  