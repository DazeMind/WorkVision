<script setup>
  import { RouterView } from 'vue-router'
  import FooterComplete from '../src/layouts/FooterComplete.vue'
  import '@fullcalendar/core/main.css';
  import '@fullcalendar/daygrid/main.css';
  import '@fullcalendar/interaction/main.css';

</script>
<template>
  <RouterView/>
  <FooterComplete/>
</template>
