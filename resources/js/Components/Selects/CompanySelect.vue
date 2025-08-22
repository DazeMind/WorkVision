<template>
  <div>
    <label
      :for="inputId"
      class="block text-gray-700 dark:text-gray-400 text-sm font-bold mb-2"
    >
      {{ label }} <code class="text-red-500">*</code>
    </label>

    <DynamicMultiSelect
      :model-value="modelValue"
      @update:modelValue="$emit('update:modelValue', $event)"
      :options="options"
      :placeholder="placeholder"
      :mode="mode"
      :searchable="searchable"
      class="w-full border p-2 rounded-xl dark:text-gray-400"
      :required="required"
      :id="inputId"
    />
  </div>
</template>

<script setup>
import { onMounted } from 'vue'
import DynamicMultiSelect from "@/Components/DynamicMultiSelect.vue"

const props = defineProps({
  modelValue: {
    type: [String, Number, Array, Object],
    required: true,
  },
  label: {
    type: String,
    default: 'Empresa',
  },
  options: {
    type: Array,
    required: true,
  },
  placeholder: {
    type: String,
    default: 'Selecciona una opción',
  },
  mode: {
    type: String,
    default: 'single',
  },
  searchable: {
    type: Boolean,
    default: true,
  },
  required: {
    type: Boolean,
    default: false,
  },
  inputId: {
    type: String,
    default: 'id_company',
  },
})

const emit = defineEmits(['update:modelValue'])

// Auto-selecciona opción única
onMounted(() => {
  if (Array.isArray(props.options) && props.options.length === 1) {
    emit('update:modelValue', props.options[0].id)
  }
})
</script>
