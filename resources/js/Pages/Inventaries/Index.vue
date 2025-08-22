<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Gestor de Inventarios
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
                <p class="text-lg font-semibold leading-tight text-right ms-5">Inventario</p>
                <Button
                    external
                    variant="black"
                    class="flex items-center gap-2 w-full sm:w-auto max-w-xs bg-blue-700 me-5"
                    href=""
                    @click="toggleFormCreateProduct"
                >
                <PlusCircleIcon class="h-5" />
                    Agregar Producto / Material
                </Button>
            </div>

            <div class="relative overflow-x-auto max-w-full">
                <table class="table-auto text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th class="px-6 py-3 w-[13%]">ACCIONES</th>
                            <th class="py-3 w-[7%]">ID Material</th>
                            <th class="px-6 py-3 w-[12.5%]">Nombre</th>
                            <th class="px-6 py-3 w-[12.5%]">Tipo</th>
                            <th class="px-6 py-3 w-[12.5%]">Precio Compra</th>
                            <th class="px-6 py-3 w-[12.5%]">Stock actual</th>
                            <th class="px-6 py-3 w-[12.5%]">Tipo</th>
                            <th class="px-6 py-3 w-[12.5%]">Descripción</th>
                            <!-- <th class="px-6 py-3 w-1/12">Precio Venta</th> -->
                        </tr>
                    </thead>
                    <tbody class="text-center">
                            <tr v-for="(material, index) in materials.data" :key="material.id" @click="ShowOrderDetails(material)" class="cursor-pointer hover:bg-gray-100 transition-colors" >
                                <td class="px-6 py-3 flex space-x-2 item-center">
                                    <Button
                                        variant="warning"
                                        title="Gestionar Proyecto"
                                        size="sm"
                                        class="items-center gap-2 max-w-xs p-1 ms-1"
                                        @click.stop="ShowProject(material.id)"
                                        :disabled="true"
                                    >
                                        <ChartSquareBarIcon class="w-5 h-5" />
                                    </Button>
                                    <Button
                                        variant="primary"
                                        title="Editar Proyecto"
                                        size="sm"
                                        class="items-center gap-2 max-w-xs p-1 ms-1"
                                        @click.stop="updateProject(material.id)"
                                        :disabled="true"
                                    >
                                        <PencilIcon class="w-5 h-5" />
                                    </Button>
                                    <Button
                                        variant="danger"
                                        title="Eliminar Proyecto"
                                        size="sm"
                                        class="items-center gap-2 max-w-xs p-1 ms-1"
                                        @click.stop="deleteProduct(material)"
                                    >
                                        <TrashIcon class="w-5 h-5" />
                                    </Button>
                                </td>
                                <td class="py-3 text-start">{{ material.id }}</td>
                                <td class="px-6 py-3 text-start">{{ material.name }}</td>
                                <td class="px-6 py-3 text-start">{{ material.type }}</td>
                                <td class="px-6 py-3 text-start">{{ material.purchase_price }}</td>
                                <td class="px-6 py-3 text-start">{{ material.stock ?? "N/A" }}</td>
                                <td class="px-6 py-3 text-start"> {{ material.type }}</td>
                                <td class="px-6 py-3 text-start">{{ material.description }}</td>
                            </tr>
                    </tbody>
                </table>
                <!-- Paginación -->
        <div class="mt-6 flex justify-center gap-2">
            <button
                v-if="materials.prev_page_url"
                @click="goToPage(materials.prev_page_url)"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
            >
                ← Anterior
            </button>

            <span class="px-4 py-2 text-sm font-semibold text-gray-700 dark:text-gray-200">
                Página {{ materials.current_page }} de {{ materials.last_page }}
            </span>

            <button
                v-if="materials.next_page_url"
                @click="goToPage(materials.next_page_url)"
                class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded hover:bg-blue-700"
            >
                Siguiente →
            </button>
            </div>
           </div>
        </div>
        <Modal :maxWidth="'full'" :show="showModalCreateProduct" @close="closeModalProduct">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Crear nuevo Producto / Material</h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">Aquí puedes añadir un nuevo producto o materiales para confeccionar productos.</p>
                <FormProductMaterial :companies="companies" :isModal="true" @closeModalProduct="closeModalProduct"/>
                <div class="mt-6 flex justify-end">
                    <Button variant="secondary" @click="closeModalProduct">Cancelar</Button>
                </div>
            </div>
        </Modal>
    </AuthenticatedLayout>
</template>

<script setup>
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import Button from '@/Components/Button.vue'
    import { ChartSquareBarIcon, PencilIcon, TrashIcon } from '@heroicons/vue/solid'
    import { router } from '@inertiajs/vue3';
    import { useForm } from '@inertiajs/inertia-vue3';
    import { DownloadIcon, PlusCircleIcon } from '@heroicons/vue/outline';
    import FlashMessage from '@/Components/FlashMessage.vue';
    import Modal from '@/Components/Modal.vue';
    import { ref } from 'vue';
    import FormProductMaterial from '../Components/OrderSales/Products/FormProductMaterial.vue';

    defineProps({
        products: Array,
        materials: Object,
        companies: Array,
        walletTypes: Array,
        wallets: Array,
        userRoles: Array,
        categories: Array,
        sub_categories: Array,
        registros: Array,
        programRecords: Array,
    });

    function goToPage(url) {
        router.visit(url, {
            preserveScroll: true,
            preserveState: true,
        })
    }
    const showModalCreateProduct = ref(false);
    const toggleFormCreateProduct = () => {
        showModalCreateProduct.value = true;
    };
    const closeModalProduct = () => {
      showModalCreateProduct.value = false;
    };
    const deleteProduct = (product) => {
        const form = useForm();
        if (confirm(`¿Estás seguro de que quieres eliminar el producto ${product.name}?`)) {
            form.delete(route('inventarios.destroy', product.id), {
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