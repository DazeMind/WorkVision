<template>
    <div :class="$attrs.class">
      <select :id="id" ref="select" v-model="selected" v-bind="{ ...$attrs, class: null }" :class="[
            'py-2 border-gray-400 rounded-md',
            'focus:border-gray-400 focus:ring focus:ring-purple-500 focus:ring-offset-2 focus:ring-offset-white',
            'dark:border-gray-600 dark:bg-dark-eval-1 dark:text-gray-300 dark:focus:ring-offset-dark-eval-1 w-full'
        ]">
        <slot />
      </select>
    </div>
  </template>
  
  <script>
  import { v4 as uuid } from 'uuid'
  
  export default {
    inheritAttrs: false,
    props: {
      id: {
        type: String,
        default() {
          return `select-input-${uuid()}`
        },
      },
      error: String,
      label: String,
      modelValue: [String, Number, Boolean],
    },
    emits: ['update:modelValue'],
    data() {
      return {
        selected: this.modelValue,
      }
    },
    watch: {
      selected(selected) {
        this.$emit('update:modelValue', selected)
      },
    },
    methods: {
      focus() {
        this.$refs.input.focus()
      },
      select() {
        this.$refs.input.select()
      },
    },
  }
  </script>