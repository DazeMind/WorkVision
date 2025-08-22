<template>
    <form @submit.prevent="enviarFormulario" enctype="multipart/form-data" class="mx-4 mt-5"> 
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4 mb-4">
            <div id="empresa">
                <CompanySelect
                    v-model="formData.id_company"
                    :options="companies"
                    label="Empresa"
                    input-id="id_company"
                    :required="true"
                />
            </div>
            <div id="tipo">
                <label class="block text-gray-700 text-sm font-bold mb-2">Tipo </label>
                <DynamicMultiSelect
                    v-model="formData.type"
                    :options="[{ id: 'Producto', name: 'Producto' },{ id: 'Servicio', name: 'Servicio' }]"
                    placeholder="Selecciona una opción"
                    mode="single"
                    searchable
                    class="w-full border p-2 rounded-xl"
                />        
            </div>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre {{ formData.type  }}</label>
            <input type="text" v-model="formData.name" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="Producto ..." />
        </div>

        <div class="col-span-1">
            <label for="sku" class="block text-gray-700 text-sm font-bold mb-2">SKU</label>
            <input type="text" v-model="formData.sku" class="w-full border p-2 rounded-xl" :isRequired="true" placeholder="SKU-01 ..."/>
        </div>

        <label for="" class="mt-4 block text-lg font-semibold text-gray-800">
            Con esta información podremos calcular tus ganancias
        </label>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">
                    Valor de compra {{ formData.type }} <Button type="button" size="sm" @click="$emit('OpenModalCalculatePurchasePrice')" title="Esta herramienta te ayudara a calcular el valor real de produccion de tu producto"> Calcular Costo </Button>
                </label>
                <p class="text-gray-500 text-xs mb-2">
                    Costo total estimado para realizar el {{ formData.type }}, incluyendo materiales , insumos y transporte 
                    (ej. repuestos, materias primas) y una parte de los gastos operativos (luz, arriendo, transporte).
                </p>
                <input 
                    type="number" 
                    v-model="formData.purchase_price" 
                    class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="90000 ..."
                    required 
                />
            </div>

            <div>
                <label class="block text-gray-700 text-sm font-medium mb-1">
                    Valor de venta {{ formData.type }}
                </label>
                <p class="text-gray-500 text-xs mb-3">
                    Precio que cobras al cliente por el {{ formData.type }}, incluyendo tu ganancia.
                </p>
                <input 
                    type="number" 
                    v-model="formData.sale_price" 
                    class="w-full border border-gray-300 p-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="150000 ..."
                    required 
                />
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Descripcion {{ formData.type  }}</label>
                <textarea v-model="formData.description" class="w-full border p-2 rounded-xl"></textarea>
            </div>
        </div>

        <div class="my-4" v-if="formData.type == 'Producto'">
            <label class="block text-gray-700 text-sm font-bold mb-2">Deseas incluir dimenciones </label>
            <DynamicMultiSelect
                    v-model="formData.dimensiones"
                    :options="[{ id: 'si', name: 'si' },{ id: 'no', name: 'no' }]"
                    placeholder="Selecciona una opción"
                    mode="single"
                    searchable
                    class="w-full border p-2 rounded-xl"
                />        
        </div>
        <div v-if="formData.dimensiones == 'si'">
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mb-6">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Alto {{ formData.type  }} (en CM) ↕</label>
                    <input type="text" v-model="formData.high" class="w-full border p-2 rounded-xl" required placeholder="110 ..."/>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Ancho {{ formData.type  }} (en CM) ↔</label>
                    <input type="text" v-model="formData.width" class="w-full border p-2 rounded-xl" required  placeholder="410 ..." />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Largo {{ formData.type  }} (en CM) ↗</label>
                    <input type="text" v-model="formData.length" class="w-full border p-2 rounded-xl" required placeholder="80 ..." />
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Peso {{ formData.type  }} (en KG)⚖️</label>
                    <input type="text" v-model="formData.weight" class="w-full border p-2 rounded-xl" required placeholder="10 ..." />
                </div>
                
                
            </div>
        </div>

        <Button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white p-3 mt-5 rounded-xl" >
            {{productSelected ? 'Actualizar' : 'Guardar'}}
        </Button>
    </form>
</template>

<script setup>
    import DynamicMultiSelect from "@/Components/DynamicMultiSelect.vue";
    import { useForm } from '@inertiajs/inertia-vue3';
    import Button from '@/Components/Button.vue'
    import CompanySelect from "@/Components/Selects/CompanySelect.vue";
    
    const props = defineProps({
        companies: Array,
        isModal: {
            type: Boolean,
            default: false
        },
        productSelected: {
            type: Object,
            default: null, // Retorna un objeto vacío por defecto
            required: false
        }   
    });
    // Datos del formulario
    const formData = useForm({
        id_company: props.productSelected?.id_company ??  '',
        type: props.productSelected?.type ?? '',
        name: props.productSelected?.name ?? '',
        sku: props.productSelected?.SKU ?? '',
        description: props.productSelected?.description ?? '',
        purchase_price: props.productSelected?.purchase_price ?? '',
        sale_price: props.productSelected?.sale_price ?? '',
        high: props.productSelected?.high ?? '',
        width: props.productSelected?.width ?? '',
        length: props.productSelected?.length ?? '',
        weight: props.productSelected?.weight ?? '',
        isModal: props.isModal,
    });    

    const emit = defineEmits(['closeModalProduct']);
    // Manejo del envío del formulario
    const enviarFormulario = () => {
        const isUpdate = !!props.productSelected;
        const routeName = isUpdate ? 'products.update' : 'products.store';
        const routeParams = isUpdate ? { product: props.productSelected.id } : {};
        const method = isUpdate ? 'put' : 'post';

        formData[method](route(routeName, routeParams), {
            onSuccess: () => {
            console.log(isUpdate ? "¡Producto actualizado con éxito!" : "¡Producto creado con éxito!");
            if (props.isModal) {
                emit('closeModalProduct');
            }
            },
            onError: (errors) => {
            alert("Ha ocurrido un error al " + (isUpdate ? "actualizar" : "crear") + " el producto. Por favor, revisa los campos.");
            console.error("Errores del servidor:", errors);
            },
            onFinish: () => {
            console.log("Proceso de envío de formulario para 'producto' finalizado.");
            }
        });
    };

</script>