<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3'
import { MoonIcon, SunIcon } from '@heroicons/vue/outline'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import PageFooter from '@/Components/PageFooter.vue'
import Button from '@/Components/Button.vue'
import { toggleDarkMode, isDark } from '@/Composables'
import logo from '@/assets/images/WorkVision.png';

defineProps({
    title: String
})
</script>
<style scoped>
.gradient-background {
  background: #03c4ff;
  background: linear-gradient(
    30deg,
    rgba(3, 196, 255, 1) 0%,
    rgb(89, 89, 236) 53%,
    rgba(0, 212, 255, 1) 100%
  );
}
</style>
<template>
    <Head :title="title" />

    <div
        class="flex flex-col items-center justify-center min-h-screen gap-4 py-6 gradient-background dark:bg-dark-eval-0"
    >
        <div class="flex-shrink-0">
            <Link href="/">
                <img :src="logo" alt="Logo de la aplicación" class="w-auto h-60" />
            </Link>
        </div>

        <main class="flex items-center flex-1 w-full sm:max-w-md">
            <div
                class="w-full px-6 py-4 overflow-hidden bg-white shadow-md  sm:rounded-lg dark:bg-dark-eval-1"
            >
                <slot />
            </div>
        </main>

        <div class="bg-white rounded-full shadow-xl" >
            <PageFooter />
        </div>

        <div class="fixed right-10 top-10">
            <Button
                iconOnly
                variant="secondary"
                type="button"
                @click="toggleDarkMode"
                v-slot="{ iconSizeClasses }"
                class="hidden md:inline-flex"
                srText="Toggle dark mode"
            >
                <MoonIcon
                    v-show="!isDark"
                    aria-hidden="true"
                    :class="iconSizeClasses"
                />
                <SunIcon
                    v-show="isDark"
                    aria-hidden="true"
                    :class="iconSizeClasses"
                />
            </Button>
        </div>
    </div>
</template>
