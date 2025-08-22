<script setup>
    import Modal from '@/Components/Modal.vue';
    import { ref } from 'vue'
import Button from '../Button.vue';

    defineProps({
        orderSelected: Object, 
        showDetails: Boolean,
    });


   const emit = defineEmits(['close']);

    const emitClose = () => {
        emit('close');
    };
</script>
<template>
    <Modal :maxWidth="'2xl'" :show="showDetails" @close="emitClose">
        <div class="p-8 bg-white dark:bg-gray-900 rounded-xl shadow-md space-y-8">
        <!-- Título Principal -->
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
            Orden Nº {{ orderSelected.id }} 
            <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                ({{ orderSelected.order_deliveries?.length > 0 ? 'Delivery' : 'Venta directa' }})
            </span>
            </h2>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Aquí puedes ver los detalles de tu pedido.</p>
        </div>

        <!-- Datos de la Orden -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Datos de la orden</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Monto Total (Venta)</label>
                <input type="number" v-model="orderSelected.sale_price" class="input-disabled" disabled />
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Monto Abonado</label>
                <input type="number" v-model="orderSelected.amount_paid" class="input-disabled" disabled />
            </div>
            <div class="flex flex-col">
                <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Saldo restante</label>
                <input type="number" :value="orderSelected.sale_price - orderSelected.amount_paid" class="input-disabled" disabled />
            </div>
            </div>

            <div class="mt-4">
            <label class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-1 block">Descripción</label>
            <textarea v-model="orderSelected.note" class="input-disabled" rows="3" disabled></textarea>
            </div>
        </div>

        <!-- Productos -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
            Datos {{ orderSelected.order_details.length > 1 ? 'de los' : 'del' }} producto
            </h3>
            <div v-for="(item, index) in orderSelected.order_details" :key="index" class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg space-y-3 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producto {{ index + 1 }}</label>
                <input type="text" :value="item.product.name" class="input-disabled" disabled />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                <input type="text" :value="item.product.description" class="input-disabled" disabled />
            </div>
            </div>
        </div>

        <!-- Entrega -->
        <div v-if="orderSelected.order_deliveries[0]">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Datos de entrega</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de entrega</label>
                    <input type="text" :value="new Date(orderSelected.order_deliveries[0].delivery_date).toLocaleDateString()" class="input-disabled" disabled />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora de entrega</label>
                    <input type="text" :value="new Date(orderSelected.order_deliveries[0].delivery_date).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' })" class="input-disabled" disabled />
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección de entrega</label>
                    <input type="text" v-model="orderSelected.order_deliveries[0].destination_address" class="input-disabled" disabled />
                </div>
            </div>
        </div>

        <!-- Cliente -->
        <div>
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Datos del cliente</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                <input type="text" v-model="orderSelected.consumer.name" class="input-disabled" disabled />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Teléfono</label>
                <input type="text" v-model="orderSelected.consumer.phone" class="input-disabled" disabled />
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Dirección</label>
                <input type="text" v-model="orderSelected.consumer.address" class="input-disabled" disabled />
            </div>
            </div>
        </div>

        <!-- Acciones -->
        <div class="flex justify-end">
            <Button @click="emitClose" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white rounded-md hover:bg-gray-300 dark:hover:bg-gray-600 transition">
            Cancelar
            </Button>
        </div>
        </div>
    </Modal>
</template>