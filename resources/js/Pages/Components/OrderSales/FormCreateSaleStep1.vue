<template>
    <form @submit.prevent="enviarFormulario" enctype="multipart/form-data" class="mx-4 mt-5">
      <ValidationErrors class="mb-4"/>
      <div class="mb-4">
          <CompanySelect
            v-model="formData.id_company"
            :options="companies"
            label="Empresa"
            input-id="id_company"
            :required="true"
          />
      </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Tipo de orden</label>
                <DynamicMultiSelect
                  v-model="formData.type"
                  :options="[{ id: 'direct_sale', name: 'Venta directa' }, { id: 'order/delivery', name: 'Pedido / delivery' }]"
                  placeholder="Selecciona una opción"
                  mode="single"
                  searchable
                  class="w-full border p-2 rounded-xl"
                  :required="true"
                />
            </div>
            <div>
                <label class="block text-gray-700 text-sm font-bold mb-2">Cliente</label>
                <DynamicMultiSelect
                  v-model="formData.client_id"
                  @select="handleClientSelect"
                  :options="[...consumers, { id: 'newClient', name: '+ Crear nuevo cliente' }]"
                  placeholder="Selecciona una opción"
                  mode="single"
                  searchable
                  class="w-full border p-2 rounded-xl"
                  :required="true"
                />
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Productos / Servicios</label>
            <DynamicMultiSelect
              v-model="formData.products"
              @select="handleSelectProduct"
              :options="[...productServices, { id: 'newProduct', name: '+ Crear nuevo producto' }]"
              placeholder="Selecciona un producto"
              mode="tags"
              searchable
              class="w-full border p-2 rounded-xl"
              :required="true"
            />
        </div>

        <div class="mb-4">
          <label class="block text-gray-700 text-sm font-bold mb-2">Descuento</label>
          <p class="text-gray-500 text-xs mb-2">Monto descontado al total del producto o servicio.</p>
          <input type="number" v-model="formData.discounts" class="w-full border p-2 rounded-xl"  />
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Monto Total</label> <!-- suma de los productos - descuentos-->
            <p class="text-gray-500 text-xs mb-2">Suma del valor de venta de los productos seleccionados</p>
            <input type="number" v-model="formData.total_amount" class="w-full border p-2 rounded-xl" disabled />
        </div>

      <!-- Método de Pago -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Método de Pago</label>
        <select v-model="formData.payment_method" class="w-full border p-2 rounded-xl" required>
          <option value="cash">Efectivo</option>
          <option value="bank_transfer">Transferencia Bancaria</option>
          <option value="card">Tarjeta de Debito/Crédito</option>
        </select>
      </div>
      <div v-if="InputVoucher">
        <label for="date" class="block text-gray-700 text-sm font-bold mb-2">Puedes subir un comprobante de la transferencia (OPCIONAL)</label>
        <div class="flex items-center justify-center w-full mb-4">
          <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-30 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
            <div class="flex flex-col items-center justify-center pt-3 pb-4">
              <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
              </svg>
              <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click para subir</span> o arrastra y suelta</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)</p>
            </div>
            <input id="dropzone-file" type="file" class="hidden" @change="handleFileChange" />
          </label>
        </div>
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Monto Abonado</label>
        <p class="text-gray-500 text-xs mb-2">Cantidad recibida por el producto o servicio.</p>
        <input type="number" v-model="formData.amount_paid" :max="formData.total_amount" class="w-full border p-2 rounded-xl"  />
      </div>

      <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Billetera</label>
            <p class="text-gray-500 text-xs mb-2">El monto se sumará a la billetera seleccionada.</p>
            <DynamicMultiSelect
              v-model="formData.id_wallet"
              :options="wallets"
              placeholder="Selecciona una billetera"
              mode="single"
              searchable
              class="w-full border p-2 rounded-xl"
            />
        </div>

      <!-- Fecha de Entrega (Solo si es Delivery) -->
      <div class="mb-4" v-if="formData.type === 'order/delivery'">

        <label class="block text-gray-700 text-sm font-bold mb-2">Fecha de Entrega</label>
        <input type="datetime-local" v-model="formData.delivery_date" class="w-full border p-2 rounded-xl" />

        <div class="mt-5">
            <label for="business1" class="block text-sm font-medium text-gray-900 dark:text-gray-300">
            ¿Su pedido es con delivery o retiro en tienda?
            </label>
            <label class="inline-flex items-center cursor-pointer mt-2">
            <span class="me-3 text-sm font-medium text-gray-900 dark:text-gray-300">Retiro en tienda</span>
            <input 
                type="checkbox" 
                v-model="formData.isDelivery" 
                class="sr-only peer"
            />
            <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
            </div>
            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Delivery</span>
            </label>
        </div>
        <div v-if="formData.isDelivery == true">
          <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 mb-4">
              <div class="mt-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Region destino</label>
                  <DynamicMultiSelect
                      v-model="formData.selectedRegion"
                      :options="regions"
                      placeholder="Selecciona una opción"
                      mode="single"
                      searchable
                      class="w-full border p-2 rounded-xl"
                  />
              </div>

              <div class="mt-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Provincia destino</label>
                  <DynamicMultiSelect
                      v-model="formData.selectedProvince"
                      :options="filteredProvinces"
                      placeholder="Selecciona una opción"
                      mode="single"
                      searchable
                      class="w-full border p-2 rounded-xl"
                  />
              </div>

              <div class="mt-4">
                  <label class="block text-gray-700 text-sm font-bold mb-2">Comuna destino</label>
                  <DynamicMultiSelect
                      v-model="formData.selectedComuna"
                      :options="filteredComunas"
                      placeholder="Selecciona una opción"
                      mode="single"
                      searchable
                      class="w-full border p-2 rounded-xl"
                  />
              </div>
          </div>

          <label class="block text-gray-700 text-sm font-bold mb-2">Direccion de entrega</label>
          <input type="text" v-model="formData.destination_address" class="w-full border p-2 rounded-xl" />

          <label class="block text-gray-700 text-sm font-bold mb-2">Direccion de salida</label>
          <input type="text" v-model="formData.address_origin" class="w-full border p-2 rounded-xl" />

          <label class="block text-gray-700 text-sm font-bold mb-2">Valor del envio</label>
          <input type="number" v-model="formData.delivery_amount" class="w-full border p-2 rounded-xl" />
        </div>
      </div>
      
      <!-- Estado de la Orden -->
      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Estado de la Orden</label>
        <DynamicMultiSelect
              v-model="formData.id_state"
              :options="OrderStates"
              placeholder="Selecciona una billetera"
              mode="single"
              searchable
              require
              class="w-full border p-2 rounded-xl"
            />
      </div>

      <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Comentarios del pedido</label>
        <textarea v-model="formData.notes" class="w-full border p-2 rounded-xl" placeholder="... Notas o comentarios acerca del pedido o envio" />
      </div>

      <!-- Subir Comprobante (Opcional) -->
      <!-- <div class="mb-4">
        <label class="block text-gray-700 text-sm font-bold mb-2">Subir Comprobante (Opcional)</label>
        <input type="file" @change="handleFileChange" class="w-full border p-2 rounded-xl" />
      </div> -->

      <!-- Botón de envío -->
      <Button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-xl"
        :disabled="!formData.client_id || !formData.products.length || !formData.total_amount"
      >
        Generar Orden
      </Button>

    </form>
    <Modal :maxWidth="'full'" :show="showModalCreateClient" @close="closeModalClient">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear nuevo Cliente</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir una agregar un nuevo cliente.</p>
        <CreateConsumer :companies="companies" :regions="regions" :provinces="provinces" :comunes="comunes" @closeModalClient="closeModalClient"/>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModalClient">Cancelar</Button>
        </div>
      </div>
    </Modal>

    <Modal :maxWidth="'full'" :show="showModalCreateProduct" @close="closeModalProduct">
      <div class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear nuevo Producto</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir un nuevo producto.</p>
        <FormProduct :companies="companies" :regions="regions" :provinces="provinces" :comunes="comunes" :isModal="true" @closeModalProduct="closeModalProduct"/>
        <div class="mt-6 flex justify-end">
          <Button variant="secondary" @click="closeModalProduct">Cancelar</Button>
        </div>
      </div>
    </Modal>
</template>

<script setup>
  import { ref, watch,computed,defineProps } from 'vue';
  import DynamicMultiSelect from "@/Components/DynamicMultiSelect.vue";
  import Modal from '@/Components/Modal.vue';
  import CreateConsumer from './Consumers/CreateConsumer.vue';
  import Button from '@/Components/Button.vue';
  import { useForm } from '@inertiajs/inertia-vue3';
  import CompanySelect from '@/Components/Selects/CompanySelect.vue';
  import ValidationErrors from '@/Components/ValidationErrors.vue'
  import FormProduct from './Products/FormProduct.vue';

  const props = defineProps({
      orderSelected: {
        type: Object,
        default: () => []
      },
      consumers: {
        type: Array,
        default: () => []
      },
      productServices: {
        type: Array,
        default: () => []
      },
      companies: {
        type: Array,
        default: () => []
      },
      regions: {
        type: Array,
        default: () => []
      },
      provinces: {
        type: Array,
        default: () => []
      },
      comunes: {
        type: Array,
        default: () => []
      },
      wallets:Array,        
      OrderStates:Array        
  });

  // Datos del formulario
  const formData = useForm({
    //order
    type: '',
    id_company: '',
    client_id: '',
    id_wallet: '',
    products: [],
    discounts: props.orderSelected?.discount ?? 0,
    total_amount: props.orderSelected?.total_amount ?? 0,
    payment_method: '',
    amount_paid: props.orderSelected?.amount_paid ?? 0,
    notes: props.orderSelected?.note ?? '',
    id_state: props.orderSelected?.id_state ?? '',
    //Delivery
    delivery_date:'',
    isDelivery:false,
    selectedRegion:'',
    selectedProvince:'',
    selectedComuna:'',
    destination_address: '',
    delivery_address: '',
    address_origin: '',
    delivery_amount: '',
    //archivo
    receipt: null,
    file:null,
  });

    const showModalCreateClient = ref(false)
    const showModalCreateProduct = ref(false)

    const emit = defineEmits(['closeModalCreateSale']);

    //Methods

    

    const filteredProvinces = computed(() =>
        props.regions.find(r => r.id === formData.selectedRegion)?.province || []
    );

    const filteredComunas = computed(() =>
        filteredProvinces.value.find(p => p.id === formData.selectedProvince)?.comuna || []
    );

    // Crea producto
    const handleSelectProduct = (selected) => {
      if (selected === 'newProduct') {
        showModalCreateProduct.value = true;
      } else {
        formData.products = formData.products.filter(p => p !== 'newProduct');
        formData.products.push(selected);
      }
    };
    function updateTotalAmount() {
      const selectedItems = props.productServices.filter(p =>
        formData.products.includes(p.id)
      );

      const subtotal = selectedItems.reduce((sum, p) => sum + p.sale_price, 0);
      const discount = Number(formData.discounts) || 0;

      formData.total_amount = subtotal - discount;
    }
    
    // Watch para productos seleccionados
    watch(() => formData.products, (selectedProducts) => {
      if (selectedProducts.includes('newProduct')) {
        showModalCreateProduct.value = true;
        formData.products = selectedProducts.filter(p => p !== 'newProduct');
      }

      updateTotalAmount();
    }, { deep: true });

    // Watch para el descuento
    watch(() => formData.discounts, () => {
          updateTotalAmount();
    });

    
    const InputVoucher = ref(null);
    // Observa cambios en el método de pago
    watch(() => formData.payment_method, (newMethod) => {
       InputVoucher.value = true ? newMethod === 'bank_transfer' : InputVoucher.value = false; 
    })
    
    // Crea cliente
    const handleClientSelect = (selected) => {
      if (selected === 'newClient') {
        showModalCreateClient.value = true;
        formData.client_id = null;
      } else {
        formData.client_id = selected;
      }
    };
    watch(() => formData.client_id, (selectedClient) => {
      if (selectedClient === 'newClient') {
        showModalCreateClient.value = true;
        formData.client_id = null;
      }
    });

    // Calcula el monto total automáticamente al seleccionar productos
    // watch(() => formData.value.products, (selectedProducts) => {
    //   

    //   const selectedItems = products.value.filter(p => selectedProducts.includes(p.id));
    //   formData.value.total_amount = selectedItems.reduce((sum, p) => sum + p.price, 0);
    // });


// Manejo de archivos
    function handleFileChange(event) {
      const file = event.target.files[0];
      if (file) {
        console.log("Archivo seleccionado:", file);
      } else {
        console.warn("No se seleccionó ningún archivo.");
      }
      formData.file = file;
    };
// Envío del formulario
const enviarFormulario = () => {
  formData.post(route('ordenes-y-ventas.store'), {
     forceFormData: true,
      onSuccess: () => {
          alert("Orden generada correctamente");
          emit('closeModalCreateSale');
        },
      onError: (errors) => {
          console.error('Error en el formulario:', errors);
          alert("Error al enviar formulario");

      }
  });
};

    const closeModalClient = () => {
        showModalCreateClient.value = false;
    };
    const closeModalProduct = () => {
      showModalCreateProduct.value = false;
    };

</script>
