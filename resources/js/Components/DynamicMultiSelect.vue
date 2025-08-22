<template>
    <div>
        <Multiselect
            v-model="innerValue"
            :options="optionsSelect"
            :mode="mode"
            :placeholder="placeholder"
            :searchable="true"
            @update:modelValue="updateValue"
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
        mode: {
            type: String,
            default: 'tags',
        },
        options: {
            type: [Array, Object],
            required: true,
        },
        placeholder: String,
        modelValue: {
            type: [Array, Object, String, Number],
            default: null,
        },
        maxTags: {
            type: Number,
            default: Infinity,
        },
    },
    data() {
        return {
            innerValue: this.modelValue,
            optionsSelect: this.formatOptions(this.options)
        }
    },
    watch: {
        modelValue(newValue) {
            this.innerValue = newValue;
        },
        innerValue(newValue) {
            this.$emit('update:modelValue', newValue);
        },
        options: {
            handler(newOptions) {
                this.optionsSelect = this.formatOptions(newOptions);
            },
            deep: true,
        },
    },
    methods: {
        formatOptions(options) {
            return Array.isArray(options) ? options.map((item) => {
                if (typeof item === 'number') {
                    // Es un año
                    return {
                        value: item,
                        label: item.toString()
                    };
                } else {
                    // Es un objeto con diferentes posibles propiedades
                return {
                    value: item.id,
                    label: item.name ? item.name : 
                          (item.type_car ? item.type_car : 
                          (item.month ? item.month : 
                          (item.plate ? item.plate : 'Nombre no disponible')))
                }}
            }) : [];
        },
        updateValue(value) {
            if (Array.isArray(value) && value.length > this.maxTags) {
                value = [value[value.length - 1]];
            }
            this.$emit('update:modelValue', value);
        }
    }
}
</script>

<style src="@vueform/multiselect/themes/default.css"></style>
