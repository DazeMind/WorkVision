<script setup>
import { Link } from '@inertiajs/inertia-vue3'

const props = defineProps({
    href: String,
    title: String,
    active: {
        type: Boolean,
        default: false,
    },
    external: {
        type: Boolean,
        default: false,
    },

})


const { external } = props

const Tag = external ? 'a' : Link
</script>

<template>
    <li
        :class="[
            'relative leading-8 m-0 pl-6',
            'before:block before:w-4 before:h-0 before:absolute before:left-0 before:top-4 before:border-t-2 before:border-t-gray-200 before:-mt-0.5',
            'last:before:bg-white last:before:h-auto last:before:top-4 last:before:bottom-0',
            'dark:last:before:bg-dark-eval-1 dark:before:border-t-gray-600',
        ]"
    >
        <component
            :is="Tag"
            :href="href"
            v-bind="$attrs"
            :class="[
                'p-2 w-full flex items-center gap-3 rounded-md transition-colors duration-200 text-sm font-medium group',
                active
                    ? 'bg-blue-600 text-white shadow-md ring-1 ring-blue-500/50 hover:bg-blue-700'
                    : 'text-gray-500 hover:text-gray-700 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-gray-200 dark:hover:bg-dark-eval-2',
            ]"
        >
            {{ title }}
        </component>
    </li>
</template>
