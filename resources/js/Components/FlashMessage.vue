<script setup>
import {
    InformationCircleIcon,
    XIcon,
    ExclamationIcon,
    CheckCircleIcon,
    XCircleIcon
} from "@heroicons/vue/outline";
import {computed} from 'vue'
const props = defineProps({
    variant: {
        type: String,
        default: 'success',
        validator(value) {
            return ['success', 'danger', 'warning', 'info'].includes(value)
        },
    },
    title: String,
    content: String,
    show: {
        type: Boolean,
        default: true
    },
    onDismiss: Function
})
const {variant} = props
const classes = computed(() => [
    ...baseClasses,
    variantClasses(variant)
])
const baseClasses = [
    'flex p-4 rounded-md space-x-3',
]

const variantClasses = (variant) => ({
    'bg-green-100 text-green-900': variant == 'success',
    'bg-red-100 text-red-900': variant == 'danger',
    'bg-yellow-100 text-yellow-900': variant == 'warning',
    'bg-blue-100 text-blue-900': variant == 'info',

})
const variantButton = computed(() => [
variantClassesButton(variant)
])

const iconComponent = computed(()=>{
    const icons = {
        success: CheckCircleIcon,
        danger: XCircleIcon,
        warning: ExclamationIcon,
        info: InformationCircleIcon,
    }
    return icons[variant]
})

const variantClassesButton = (variant) => ({
    'text-green-900/70 hover:text-green-900 hover:bg-green-200 p-0.5 rounded-md': variant == 'success',
    'text-red-900/70 hover:text-red-900 hover:bg-red-200 p-0.5 rounded-md': variant == 'danger',
    'text-yellow-900/70 hover:text-yellow-900 hover:bg-yellow-200 p-0.5 rounded-md': variant == 'warning',
    'text-blue-900/70 hover:text-blue-900 hover:bg-blue-200 p-0.5 rounded-md': variant == 'info',
})
function dismiss(){
    if(props.onDismiss){
        props.onDismiss();
    }
}
</script>


<template>
    <transition v-if="props.show" leave-active-class="duration-300" leave-to-class="opacity-0">
        <div :class="classes">
        <div class="shrink-0">
            <component :is="iconComponent" class="w-6 h-6"/>
        </div>
        <div class="flex-1 space-y-2">
            <h2 class="font-medium">{{ title }}</h2>
            <div class="text-sm">{{ content }}</div>
        </div>
        <div class="shrink-0" v-if="props.onDismiss">
            <button @click="dismiss()" :class="variantButton">
                <XIcon class="w-6 h-6"/>
            </button>
        </div>
    </div>
    </transition>
</template>

