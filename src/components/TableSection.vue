<template>
    <div class="grid gap-4 md:gap-6">
        <SectionTitle>
            <template #title><slot name="title"></slot></template>
            <template #description><slot name="description"></slot></template>
            <template #button><slot name="button"></slot></template>
        </SectionTitle>
        <div class="mt-5 md:mt-0 md:col-span-2">
            <div class="px-4 py-5 bg-white shadow-md sm:p-6 dark:bg-dark-eval-1">
                <div class="grid grid-cols-1">
                    <slot name="table"></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { useSlots, computed } from 'vue'
import SectionTitle from '@/Components/SectionTitle.vue'

const slots = useSlots()

const hasActions = computed(() => {
        return !!slots.actions
})
</script>