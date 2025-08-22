<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Gestor de Productos
                </h2>
            </div>
        </template>

        <div class="p-6 bg-white rounded-md shadow-md dark:bg-dark-eval-1 mb-4">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 xl:grid-cols-6 gap-4">
                <Button
                    external
                    variant="black"
                    class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
                    href=""
                    @click=""
                    disabled
                >
                    <DownloadIcon class="w-5 h-5 mr-2" />
                    Exportar Existencias
                </Button>
            <Button
                external
                variant="black"
                class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
                href=""
                @click=""
                disabled
            >
                <DownloadIcon class="w-5 h-5 mr-2" />
                Exportar Productos
            </Button>
            <Button
                external
                variant="black"
                class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
                href=""
                @click=""
                disabled
            >
                <DownloadIcon class="w-5 h-5 mr-2" />
                Exportar General
            </Button>
            <Button
                external
                variant="black"
                class="flex items-center gap-2 w-full max-w-xs bg-blue-700"
                href=""
                @click=""
                disabled
            >
                <DownloadIcon class="w-5 h-5 mr-2" />
                Crear Proyecto
            </Button>
            </div>
        </div>
        <div v-if="$page.props.flash.message" class="mt-4 p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <FlashMessage
                :show="$page.props.flash.message"
                :on-dismiss="() => ($page.props.flash.message = false)"
                :title="$page.props.flash.title"
                :content="$page.props.flash.content"
                :variant="$page.props.flash.type"
            /> 
        </div>

        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="flex justify-between items-center mb-5">
                <p class="text-lg font-semibold leading-tight text-right ms-5">Mis Productos</p>
                <Button
                    external
                    variant="black"
                    class="flex items-center gap-2 w-full sm:w-auto max-w-xs bg-blue-700 me-5"
                    href=""
                    @click="toggleFormCreateProduct"
                >
                <PlusCircleIcon class="h-5" />
                    Crear Producto
                </Button>
            </div>

            <div class="relative overflow-x-auto max-w-full">
                <table class="table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 w-1/12">ACCIONES</th>
                            <th class="py-3 w-1/12">ID Producto</th>
                            <th v-if="$page.props.auth.user.roles.some(role => role.name === 'SuperAdmin')" class="px-6 py-3 w-1/12">Empresa</th>
                            <th class="px-6 py-3 w-1/12">Nombre</th>
                            <th class="px-6 py-3 w-1/12">Descripción</th>
                            <th class="px-6 py-3 w-1/12">Precio Venta</th>
                            <th class="px-6 py-3 w-1/12">Precio Compra</th>
                            <th class="px-6 py-3 w-1/12">Stock actual</th>
                            <th class="px-6 py-3 w-1/12">SKU</th>
                            <th class="px-6 py-3 w-1/12">Tipo</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <template v-for="(company, companyIndex) in companies" :key="companyIndex">
                            <tr v-for="(product, productIndex) in products" :key="productIndex" @click="ShowOrderDetails(product)" class="cursor-pointer hover:bg-gray-100 transition-colors" >
                                <td class="px-6 py-3 flex space-x-2 items-center">
                                    <Button
                                        variant="warning"
                                        title="Gestionar Proyecto"
                                        size="sm"
                                        class="items-center gap-2 max-w-xs p-1 ms-1"
                                        @click.stop="ShowProject(product.id)"
                                        :disabled="true"
                                    >
                                        <ChartSquareBarIcon class="w-5 h-5" />
                                    </Button>
                                    <Button
                                        variant="primary"
                                        title="Editar Proyecto"
                                        size="sm"
                                        class="items-center gap-2 max-w-xs p-1 ms-1"
                                        @click.stop="updateProject(product)"
                                    >
                                        <PencilIcon class="w-5 h-5" />
                                    </Button>
                                    <Button
                                        variant="danger"
                                        title="Eliminar Proyecto"
                                        size="sm"
                                        class="items-center gap-2 max-w-xs p-1 ms-1"
                                        @click.stop="deleteProduct(product)"
                                    >
                                        <TrashIcon class="w-5 h-5" />
                                    </Button>
                                </td>
                                <td class="py-3">{{ product.id }}</td>
                                <td v-if="$page.props.auth.user.roles.some(role => role.name === 'SuperAdmin')" class="px-6 py-3">{{ company.name }}</td>
                                <td class="px-6 py-3">{{ product.name }}</td>
                                <td class="px-6 py-3">{{ product.description }}</td>
                                <td class="px-6 py-3">{{ product.sale_price }}</td>
                                <td class="px-6 py-3">{{ product.purchase_price }}</td>
                                <td class="px-6 py-3">{{ product.stock ?? "N/A" }}</td>
                                <td class="px-6 py-3"> {{ product.SKU }}</td>
                                <td class="px-6 py-3"> {{ product.type }}</td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>

            <Modal :maxWidth="'full'" :show="showModalCreateProduct" @close="closeModalProduct">
                <div class="p-6">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear nuevo Producto</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir un nuevo producto.</p>
                    <FormProduct :companies="companies" :productSelected="productSelected" :isModal="true" @closeModalProduct="closeModalProduct"/>
                    <div class="mt-6 flex justify-end">
                    <Button variant="secondary" @click="closeModalProduct">Cancelar</Button>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
    import { ref } from 'vue';
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import Button from '@/Components/Button.vue'
    import { ChartSquareBarIcon, PencilIcon, TrashIcon } from '@heroicons/vue/solid'
    import { router } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/inertia-vue3';
    import { DownloadIcon, PlusCircleIcon } from '@heroicons/vue/outline';
    import FlashMessage from '@/Components/FlashMessage.vue';
    import Modal from '@/Components/Modal.vue';
    import FormProduct from '@/Pages/Components/OrderSales/Products/FormProduct.vue';

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
    });

    const showModalCreateProduct = ref(false);
    const productSelected = ref(null);

    const updateProject = (product) => {
        productSelected.value = product;
        showModalCreateProduct.value = true;
        console.log("product sleleccteds",productSelected.value);
    };
    const toggleFormCreateProduct = () => {
        showModalCreateProduct.value = true;
        // router.visit(route('inventarios.create'));
    };

    const closeModalProduct = () => {
      showModalCreateProduct.value = false;
    };
    const deleteProduct = (product) => {
        const form = useForm();
        if (confirm(`¿Estás seguro de que quieres eliminar el producto ${product.name}?`)) {
            form.delete(route('products.destroy', product.id), {
                onSuccess: () => {
                console.log('Producto eliminado correctamente');
                alert("Producto eliminado correctamente");
                },
                onError: (errors) => {
                console.error('Error al eliminar el Producto:', errors);
                alert("Hubo un error al eliminar el Producto");
                }
            });
        }
    }
</script>