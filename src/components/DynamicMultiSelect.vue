<template>
    <div>
        <Multiselect
      v-model="innerValue"
      :options="optionsSelect"
      :mode="mode"
      :placeholder="placeholder"
      :searchable="true"
    />
    </div>
</template>

<script>
import Multiselect from '@vueform/multiselect'

export default {
    components: {
        Multiselect
    },
    props: {
        mode: String,
        options: {
            type: Array, 
            default: () => []
        },
        placeholder: String,
        modelValue: {
        type: [Array, Object, String, Number],
        default: null
        }
    },
    data() {
        return {
            innerValue: this.modelValue,
            optionsSelect: this.options.map((item) => {
                return {
                    ["value"]: item.id,
                    ["label"]: item.name ? item.name : 
                            (item.last_name? item.last_name : 
                            (item.type_car ? item.type_car : 
                            (item.month ? item.month : 
                            (item.contract_type ? item.contract_type :
                            (item.name_var ? item.name_var :
                            (item.plate ? item.plate : 'Nombre no disponible'))))))
                }
            })
        }
    },
    watch: {
        modelValue(newValue) {
            this.innerValue = newValue
        },
        innerValue(newValue) {
            this.$emit('update:modelValue', newValue);
            this.$emit('change', newValue);
        },
        options: {
            handler(newOptions) {
                this.optionsSelect = this.formatOptions(newOptions);
            },
            immediate: true,
            deep: true
        }
    },
    methods: {
    formatOptions(options) {
      return options.map((item) => {
        return {
          value: item.id,
          label: item.name || item.last_name || item.plate || item.contract_type || item.name_var || 'Sin nombre disponible'
        };
      });
    }
  },
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>