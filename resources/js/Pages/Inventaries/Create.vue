<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Gestor de Inventarios
                </h2>
            </div>
        </template>

        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="relative overflow-x-auto max-w-full">
                <FormProduct :regions="regions" :companies="companies" @OpenModalCalculatePurchasePrice="OpenModalCalculatePurchasePrice" />
            </div>
        </div>

        <!-- Modal -->
        <div v-if="isModalCalculateVisible" class="modal-overlay fixed inset-0 bg-gray-500 bg-opacity-50 flex justify-center items-center z-50">
            <div class="p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-4">
                <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 xl:grid-cols-1">
                    <p class="">Calculador de costos</p>
                    <p class="">Si no sabes calcular los costos de tus Productos/Servicio utiliza esta herramienta</p>
                        <div class="p-6 max-w-3xl mx-auto">
                            <form @submit.prevent>
                            <div class="grid grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Seleccione tipo producto</label>
                                    <DynamicMultiSelect
                                        v-model="formData2.type"
                                        :options="[{ id: 'Gramos', name: 'Gramos' }, { id: 'Unidad', name: 'Unidad' }]"
                                        placeholder="Selecciona una opción"
                                        mode="single"
                                        searchable
                                        class="w-full border p-2 rounded-xl"
                                        :required="true"
                                    />                            
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Nombre del producto</label>
                                    <input type="text" v-model="formData2.name" class="w-full border p-2 rounded-xl" required placeholder="Ej: Harina" />
                                </div>
                                <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Cantidad en {{formData2.type}}</label>
                                <input type="number" v-model.number="formData2.grams" class="w-full border p-2 rounded-xl" required placeholder="Ej: 500" />
                                </div>
                                <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Contenido del envase {{formData2.type}}</label>
                                <input type="number" v-model.number="formData2.content" class="w-full border p-2 rounded-xl" required placeholder="Ej: 1000" />
                                </div>
                                <div>
                                <label class="block text-gray-700 text-sm font-bold mb-2">Valor del envase ($)</label>
                                <input type="number" v-model.number="formData2.price" class="w-full border p-2 rounded-xl" required placeholder="Ej: 3000" />
                                </div>
                            </div>

                            <div class="mt-4 flex gap-4">
                                <Button type="button" @click="addIngredient" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">+</Button>
                                <Button type="button" @click="calculateTotal" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">Calcular</Button>
                            </div>
                            </form>

                            <div class="mt-6">
                            <h2 class="text-lg font-bold mb-2">Ingredientes:</h2>
                            <ul class="list-disc pl-6" v-if="ingredients.length">
                                <li v-for="(ingredient, index) in ingredients" :key="index">
                                {{ ingredient.name }} - ${{ ingredient.calculatedPrice.toFixed(2) }}
                                ({{ ingredient.grams }}g de {{ ingredient.content }}g, envase: ${{ ingredient.price }})
                                </li>
                            </ul>
                            <p v-else class="text-gray-500">No hay ingredientes aún.</p>
                            </div>

                            <div v-if="totalPrice !== null" class="mt-4 text-xl font-bold text-green-700">
                            Total: ${{ totalPrice.toFixed(0) }}
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-6">
                            <Button type="button" variant="success" @click="insertAmount(totalPrice.toFixed(0))">Insertar monto</Button>
                            <Button variant="danger" @click="closeModalCalculatePurchasePrice">Cancelar</Button>
                        </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import Button from '@/Components/Button.vue'
    import { useForm } from '@inertiajs/inertia-vue3';
    import DynamicMultiSelect from "@/Components/DynamicMultiSelect.vue";
    import { router } from '@inertiajs/vue3';
    import { ref } from 'vue';
    import FormProduct from '@/Pages/Components/OrderSales/Products/FormProduct.vue';

    const isModalCalculateVisible = ref(false);

    defineProps({
        products: Array,
        companies: Array,
        walletTypes: Array,
        wallets: Array,
        userRoles: Array,
        categories: Array,
        sub_categories: Array,
        registros: Array,
        programRecords: Array,
        regions: Array,
    });

    const formData = useForm({
        type: '',
        name: '',
        id_company: '',
        description: '',
        sale_price: 0,
        purchase_price: 0,
        sku: '',
        height: '',
        weight: '',
        width: '',
        length: '',
    });

    const formData2 = ref({
        name: '',
        grams: null,
        content: null,
        price: null
    });

    const ingredients = ref([]);
    const totalPrice = ref(null);

    function addIngredient() {
    const { name, grams, content, price } = formData2.value;

    if (!name || grams <= 0 || content <= 0 || price <= 0) {
        alert('Por favor completa todos los campos correctamente.');
        return;
    }

    const calculatedPrice = (grams / content) * price;

    ingredients.value.push({
        name,
        grams,
        content,
        price,
        calculatedPrice
    });

    // Reset form
    formData2.value = {
        name: '',
        grams: null,
        content: null,
        price: null
    };

    totalPrice.value = null;
    }

    function calculateTotal() {
    if (ingredients.value.length === 0) {
        alert('Agrega al menos un ingrediente.');
        return;
    }

    totalPrice.value = ingredients.value.reduce(
        (acc, ing) => acc + ing.calculatedPrice,
        0
    );
    }

    const OpenModalCalculatePurchasePrice =  () => {
        isModalCalculateVisible.value = true;
    }
    const insertAmount =  (purchase_price) => {
        isModalCalculateVisible.value = false;
        formData.purchase_price = purchase_price;
    }
    const closeModalCalculatePurchasePrice = () => {
        isModalCalculateVisible.value = false;
    };
    const sendForm = () =>{
        formData.post(route('inventarios.store'), {
            onSuccess: () => {
                alert("Producto Registrado Correctamente");
                    router.visit(route('inventarios.index'));
                },
            onError: (errors) => {
                console.error('Error en el formulario:', errors);
            }
        });
    }

</script>


