<template>
    <!-- Mobile bottom bar -->
    <div
        :class="[
            'fixed inset-x-0 bottom-0 flex items-center justify-end px-4 py-2 sm:px-6 sm:py-4 transition-transform duration-500 bg-white md:hidden dark:bg-dark-eval-1',
            {
                'translate-y-full': scrolling.down,
                'translate-y-0': scrolling.up,
            },
        ]"
    >


        <Button
            iconOnly
            variant="secondary"
            type="button"
            @click="sidebarState.isOpen = !sidebarState.isOpen"
            v-slot="{ iconSizeClasses }"
            srText="Toggle sidebar"
        >
            <MenuIcon
                v-show="!sidebarState.isOpen"
                aria-hidden="true"
                :class="iconSizeClasses"
            />
            <XIcon
                v-show="sidebarState.isOpen"
                aria-hidden="true"
                :class="iconSizeClasses"
            />
        </Button>
    </div>
</template>

<script setup>
import { onMounted, onUnmounted } from 'vue'
import { Link } from '@inertiajs/inertia-vue3'
import { Inertia } from '@inertiajs/inertia'
import { useFullscreen } from '@vueuse/core'
import {
    SunIcon,
    MoonIcon,
    SearchIcon,
    MenuIcon,
    XIcon,
    ArrowsExpandIcon
} from '@heroicons/vue/outline'
import { ArrowsInnerIcon } from '@/Components/Icons/Outline'
import {
    handleScroll,
    isDark,
    scrolling,
    toggleDarkMode,
    sidebarState,
} from '@/Composables'
import ApplicationLogo from '@/Components/ApplicationLogo.vue'
import Button from '@/Components/Button.vue'
import Dropdown from '@/Components/Dropdown.vue'
import DropdownLink from '@/Components/DropdownLink.vue'

const { isFullscreen, toggle: toggleFullScreen } = useFullscreen()

onMounted(() => {
    document.addEventListener('scroll', handleScroll)
})
onUnmounted(() => {
    document.removeEventListener('scroll', handleScroll)
})

const logout = () => {
    Inertia.post(route('logout'));
}

const switchToTeam = (team) => {
    Inertia.put(route('current-team.update'), {
        'team_id': team.id
    }, {
        preserveState: false
    })
}
</script>
