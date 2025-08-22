<template>
    <div class="mb-4">
      <label for="afp" :class="labelClass">Selecciona AFP</label>
      <select v-model="selectedAFP" :class="inputClass" required>
        <option value="" disabled selected>Selecciona una AFP</option>
        <option v-for="(afp, index) in afpList" :key="index" :value="afp">
          {{ afp }}
        </option>
      </select>
    </div>
  </template>
  
  <script>
  export default {
    name: "SelectAFP",
    props: {
      modelValue: String,
      inputClass: String,
      labelClass: String,
    },
    data() {
      return {
        afpList: [
        "Capital",
        "Cuprum",
        "Habitat",
        "Modelo",
        "PlanVital",
        "Provida",
        "Uno",
        ]
      };
    },
    computed: {
      selectedAFP: {
        get() {
          return this.modelValue; // Obtiene el valor del v-model
        },
        set(value) {
          this.$emit("update:modelValue", value); // Actualiza el v-model cuando cambia
        },
      },
    },
  };
  </script>
  
  <style scoped>
  /* Puedes agregar estilos aquí si lo necesitas */
  </style>
  