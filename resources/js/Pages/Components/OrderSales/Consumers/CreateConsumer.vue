<template>
    <form @submit.prevent="enviarFormulario" enctype="multipart/form-data" class="mx-4 mt-5"> 
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            <div>
                <CompanySelect
                    v-model="formData.id_company"
                    :options="companies"
                    label="Selecciona la empresa"
                    input-id="id_company"
                    :required="true"
                />
            </div>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Nombre cliente</label>
            <input type="text" v-model="formData.name" class="w-full border p-2 rounded-xl" required />
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Correo Electrónico cliente</label>
            <input type="email" v-model="formData.email" v-if="!withoutEmail" class="w-full border p-2 rounded-xl"  />
             <p class="mt-2"> ¿Cliente sin correo? <Checkbox v-model="withoutEmail" @change="withoutMail" class="ms-3" /> </p> 
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Teléfono cliente</label>
            <input type="text" v-model="formData.phone" class="w-full border p-2 rounded-xl" required />
        </div>
        <!-- <div class="grid grid-cols-3 sm:grid-cols-3 gap-4 mb-4">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Region cliente</label>
                <DynamicMultiSelect
                    v-model="formData.selectedRegion"
                    :options="regions"
                    placeholder="Selecciona una opción"
                    mode="single"
                    searchable
                    class="w-full border p-2 rounded-xl"
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Provincia cliente</label>
                <DynamicMultiSelect
                    v-model="formData.selectedProvince"
                    :options="filteredProvinces"
                    placeholder="Selecciona una opción"
                    mode="single"
                    searchable
                    class="w-full border p-2 rounded-xl"
                />
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Comuna cliente</label>
                <DynamicMultiSelect
                    v-model="formData.selectedComuna"
                    :options="filteredComunas"
                    placeholder="Selecciona una opción"
                    mode="single"
                    searchable
                    class="w-full border p-2 rounded-xl"
                />
            </div>
        </div> -->

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Dirección cliente</label>
            <input type="text" v-model="formData.address" class="w-full border p-2 rounded-xl" required />
        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 hover:bg-blue-500 text-white p-3 rounded-xl"
        >
            Guardar
        </button>
    </form>
</template>

<script setup>
    import { ref, computed ,watch } from 'vue';
    import { useForm } from '@inertiajs/inertia-vue3';
    import CompanySelect from '@/Components/Selects/CompanySelect.vue';
import Checkbox from '@/Components/Checkbox.vue';
import { without } from 'lodash';

    const props = defineProps({
        companies: Array,
        regions: Array,
    });
    // Datos del formulario
    const withoutEmail = ref(null);
    const formData = useForm({
        id_company: '',
        name: '',
        email: '',
        phone: '',
        address: '',
    });    

    const emit = defineEmits(['closeModalClient']);

    function withoutMail() {
         if (withoutEmail.value) {
            formData.email = 'x@x.cl'
        } else {
            formData.email = null
        }

        console.log('Checkbox cambiado. Nuevo valor:', formData.email)
    }
    // const filteredProvinces = computed(() =>
    //     props.regions.find(r => r.id === formData.value.selectedRegion)?.province || []
    // );

    // const filteredComunas = computed(() =>
    //     filteredProvinces.value.find(p => p.id === formData.value.selectedProvince)?.comuna || []
    // );

    // // Computed para construir la dirección completa
    // const computedFullAddress = computed(() => {
    //     const region = props.regions.find((r) => r.id === formData.value.selectedRegion);
    //     const comuna = filteredComunas.value.find((c) => c.id === formData.value.selectedComuna);

    //     return `Chile, ${region?.name || "Región no seleccionada"}, ${comuna?.name || "Comuna no seleccionada"}, ${formData.value.fullAddress || "Dirección no ingresada"}`;
    // });

    // // Sincroniza el `computedFullAddress` con `formData.fullAddress`
    // watch(computedFullAddress, (newAddress) => {
    //     formData.value.fullAddress = newAddress;
    // });

    // Watch para resetear provincia y comuna cuando cambia la región
    // watch(() => formData.value.selectedRegion, () => {
    //     formData.value.selectedProvince = '';
    //     formData.value.selectedComuna = '';
    // });

    // Watch para resetear comuna cuando cambia la provincia
    // watch(() => formData.value.selectedProvince, () => {
    //     formData.value.selectedComuna = '';
    // });


    // Manejo del envío del formulario
    const enviarFormulario = () => {
        formData.post(route('consumers.store'), {
            onSuccess: () => {
                emit('closeModalClient');
            },
            onError: (errors) => {
                console.error('Error en el formulario:', errors);
            }
    });
};

</script>