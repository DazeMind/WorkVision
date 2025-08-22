<template>
  <div  id="">
    <p class="text-lg font-semibold leading-tight mb-3">
      Mis Ventas
    </p>
    <div class="relative overflow-x-auto max-w-full">
      <table class="table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-6 py-3">ACCIONES</th>
            <th scope="col" class="py-3">ID Orden</th>
            <th class="px-6 py-3" v-if="user.roles[0].name === 'SuperAdmin'">
              Empresa
            </th>
            <th scope="col" class="px-6 py-3">Cliente</th>
            <th scope="col" class="px-6 py-3">Productos</th>
            <th scope="col" class="px-6 py-3">Precio Venta</th>
            <th scope="col" class="px-6 py-3">Monto Abonado</th>
            <th scope="col" class="px-6 py-3">Saldo restante</th>
            <th scope="col" class="py-3">Descuento</th>
            <th scope="col" class="px-6 py-3">Monto Total</th>
            <th scope="col" class="px-6 py-3">Tipo de entrega</th>
            <th scope="col" class="px-6 py-3">Fecha Toma de pedido</th>
              <th scope="col" class="px-6 py-3">ID Factura</th>
            <th scope="col" class="px-6 py-3">Estado</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <template v-for="(company, companyIndex) in companies" :key="companyIndex">
            <tr v-for="(order, ordersIndex) in company.orders" :key="ordersIndex"  @click="ShowOrderDetails(order)" class="cursor-pointer hover:bg-gray-100 transition-colors">
              <td class="px-6 py-3 flex space-x-2 items-center h-full">
                  <Button variant="warning" title="Gestionar Proyecto" size="sm" class="items-center gap-2 max-w-xs p-1 ms-1" @click.stop="ShowProject(order.id)" disabled>
                    <ChartSquareBarIcon class="w-5 h-5" />
                  </Button>
                  <Button variant="primary" title="Editar Proyecto" size="sm" class="items-center gap-2 max-w-xs p-1 ms-1" @click.stop="updateOrder(order)" disabled>
                    <PencilIcon class="w-5 h-5" />
                  </Button>
                  <Button variant="danger" title="Eliminar Proyecto" size="sm" class="items-center gap-2 max-w-xs p-1 ms-1" @click.stop="deleteOrder(order)">
                    <TrashIcon class="w-5 h-5" />
                  </Button>
              </td>
              <div class="px-5"> 
                <DynamicMultiSelect
                  v-model="newState[order.id]"
                  :options="OrderStates"
                  :placeholder="order.state.name"
                  mode="single"
                  @update:modelValue="editStateOrder($event, order)"
                  @click.stop
                />
              </div>
              <td class="py-3">{{ order.id }}</td>
              <td v-if="user.roles.some(role => role.name === 'SuperAdmin')" class="px-6 py-3">{{ company.name }}</td>
              <td class="px-6 py-3">{{ order.consumer.name }}</td>
              <td class="py-3">
                <!-- detalles de los productos en la orden -->
                <div
                  v-for="(detail, detailIndex) in order.order_details" :key="detailIndex"
                  class="mb-4 p-3 border rounded-lg shadow-sm bg-gray-50"
                >
                  <h4 class="font-semibold text-gray-800 mb-2">
                    Producto {{ detailIndex + 1 }}: {{ detail.product.name }}
                  </h4>
                  <p class="text-sm text-gray-700">
                    <span class="font-medium">Cantidad:</span> {{ detail.quantity }}
                  </p>
                </div>
              </td>
              <td class="px-6 py-3">{{ order.sale_price }}</td>
              <td class="px-6 py-3">{{ order.amount_paid }}</td>
              <td class="px-6 py-3">{{ order.sale_price - order.amount_paid }}</td>
              <td class=" py-3">{{ order.discounts }}</td>
              <td class="px-6 py-3">{{ order.total_amount }}</td>
              <td class="py-3">{{ order.order_deliveries.length > 0 ? `Delivery Fecha de entrega (${order.order_deliveries[0].delivery_date}) ` : 'Venta directa' }} </td>
              <td class="px-6 py-3">{{ order.order_date }}</td>
              <td class="px-6 py-3">{{ order.id_invoice ?? 'N/A' }}</td>
              <td class="px-6 py-3">{{ order.state.name }}</td>
            </tr>
          </template>
        </tbody>
      </table>
    </div>
  </div>
    <!-- modal editar orden -->
    <!-- <Modal :maxWidth="'full'" :show="showModalEditOrder" @close="closeModalEditOrder">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Editar Orden</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir una agregar un nuevo cliente.</p>
        <FormCreateSaleStep1 @closeModalCreateSale="closeModal" :orderSelected="orderSelected" :OrderStates="OrderStates" :wallets="wallets" :consumers="consumers" :productServices="productServices" :companies="companies" :regions="regions" :provinces="provinces" :comunes="comunes"/>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModalEditOrder">Cancelar</Button>
        </div>
      </div>
    </Modal> -->
    <!-- modal ver orden -->
  <ShowOrderModal :orderSelected="orderSelected" :showDetails="showDetails" @close="closeModal" />
</template>

<script setup> 
  import { TrashIcon, PencilIcon, ChartSquareBarIcon} from '@heroicons/vue/outline'
  import Button from '@/Components/Button.vue';
  import { ref } from 'vue'
  import { useForm } from '@inertiajs/inertia-vue3';
  import ShowOrderModal from '@/Components/Modals/ShowOrderModal.vue';
  import FormCreateSaleStep1 from './FormCreateSaleStep1.vue';
  import Modal from '@/Components/Modal.vue';
  import DynamicMultiSelect from '@/Components/DynamicMultiSelect.vue';

  defineProps({
    companies: Array, 
    OrderStates: Array, 
    user: Object, 
  });

  let showDetails = ref(false)
  let orderSelected = ref(null)
  let showModalEditOrder = ref(false);
  let newState = ref({})

  const editStateOrder = (selectedState, order) => {
  // Si el estado es null o undefined, no hacer nada
  if (!selectedState) {
    console.warn('Estado no seleccionado o inválido:', selectedState);
    return;
  }

  // Si el valor viene como objeto { id, name }, obtener solo el id
  const stateId = typeof selectedState === 'object' ? selectedState.id : selectedState;

  if (!stateId) {
    console.warn('stateId inválido:', stateId);
    return;
  }

  // Si es diferente al actual, enviamos el PUT
  if (stateId !== order.id_state) {
    const form = useForm();

    form.put(route('ordenes-y-ventas.editOrderState', {
      id: order.id,
      state: stateId,
    }), {
      onSuccess: () => {
        alert("Estado actualizado correctamente");
        newState.value[order.id] = null;
      },
      onError: (err) => {
        console.error('Error al actualizar estado:', err);
      }
    });
  }
};

  function deleteOrder(order){
    const form = useForm();

    form.delete(route('ordenes-y-ventas.destroy', order.id), {
      onSuccess: () => {
        console.log('Orden eliminada correctamente');
        alert("Orden eliminada correctamente");
      },
      onError: (errors) => {
        console.error('Error al eliminar la orden:', errors);
        alert("Hubo un error al eliminar la orden");
      }
    });
  };

  function updateOrder(order){
    orderSelected.value = order;
    showModalEditOrder.value = true;
  };

  function ShowOrderDetails(order){
    showDetails.value = true;
    orderSelected.value = order;
  };
  function closeModalEditOrder(){
    showModalEditOrder.value = false;
  };

  function closeModal(){
    showDetails.value = false;
    orderSelected.value = null;
  };

</script>
<style lang="postcss">
  .input-disabled {
    @apply w-full p-2 rounded-md bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-white border border-gray-300 dark:border-gray-600;
  }
</style>
