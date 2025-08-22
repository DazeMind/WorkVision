<template>
    <div class="flex flex-wrap">
        <!-- Box 1 -->
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
        <div class="bg-blue-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
            <div>
                <h3 class="text-4xl font-bold">{{ companies[0].workers.length }}</h3>
                <p class="text-lg">Colaboradores activos</p>
            </div>
            <UserGroupIcon class="w-12 h-12" />
            </div>
            <a href="#" class="block text-white text-sm mt-4 hover:underline">
            Más información <InformationCircleIcon class="inline w-5 h-5" />
            </a>
        </div>
        </div>

        <!-- Box 2 -->
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
        <div class="bg-green-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
            <div>
                <h3 class="text-4xl font-bold">{{totalIncome}}</h3>
                <p class="text-lg">Ingresos</p>
            </div>
            <CurrencyDollarIcon class="w-12 h-12" />
            </div>
            <a href="#" class="block text-white text-sm mt-4 hover:underline">
            Más información <InformationCircleIcon class="inline w-5 h-5" />
            </a>
        </div>
        </div>

        <!-- Box 3 -->
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
            <div class="bg-yellow-500 text-white rounded-lg shadow-lg p-4">
                <div class="flex justify-between items-center">
                <div>
                    <h3 class="text-4xl font-bold">0</h3>
                    <p class="text-lg">{{ companies[0].type == "orders/sales" ? "Pedidos" : "Tareas" }} pendientes</p>
                </div>
                <ClipboardListIcon class="w-12 h-12" />
                </div>
                <a href="#" class="block text-white text-sm mt-4 hover:underline">
                Más información <InformationCircleIcon class="inline w-5 h-5" />
                </a>
            </div>
        </div>

        <!-- Box 4 -->
        <div class="w-full sm:w-1/2 lg:w-1/4 p-2">
        <div class="bg-red-500 text-white rounded-lg shadow-lg p-4">
            <div class="flex justify-between items-center">
            <div>
                <h3 class="text-4xl font-bold">{{totalExpenses}}</h3>
                <p class="text-lg">Gastos</p>
            </div>
            <TrendingDownIcon class="w-12 h-12" />
            </div>
            <a href="#" class="block text-white text-sm mt-4 hover:underline">
            Más información <InformationCircleIcon class="inline w-5 h-5" />
            </a>
        </div>
        </div>
    </div>
</template>
  
  <script setup>
    import { ClipboardListIcon, CurrencyDollarIcon, InformationCircleIcon, TrendingDownIcon, UserGroupIcon } from '@heroicons/vue/outline'

    const props = defineProps({
        companies:Array,
        totalIncome: Number,
        totalExpenses: Number,
    })
  </script>