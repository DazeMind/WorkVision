<template>
    <AuthenticatedLayout title="Dashboard">
        <template #header>
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold leading-tight">
                    Gestor de Finanzas
                </h2>               
            </div>
        </template>
        
        <div class="grid grid-cols-1 sm:grid-cols-1 lg:grid-cols-2 gap-4 mb-2">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg w-full">
                <GestionIngreso :categories="categories" :wallets="wallets" />
            </div>

            <div class="sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg w-full">
                <Button @click="toggleComponent" class="hover:bg-blue-500 bg-blue-600 text-white rounded-xl m-4" size="base">
                    {{ showWallets ? 'Crear nueva billetera' : 'Ver mis billeteras' }}
                </Button>

                <div class="max-w-xxl overflow-hidden">
                    <wallets v-if="showWallets" :walletTypes="walletTypes" :wallets="wallets" class="swiper-container" />
                    <FormCreateWallet v-else @formulario-enviado="showWallets = true" :walletTypes="walletTypes" :wallets="wallets" class="max-w-xl"/>
                </div>
            </div>
        </div>
    
        <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
            <div class="">
                <RegistroCuentas :categories="categories" :wallets="wallets" :registros="registros" :programRecords="programRecords" :flash="flash" />
            </div>
            <Button
                v-if="SuperAdminRole"
                external
                variant="black"
                target="_blank"
                class="items-center gap-2 max-w-xs bg-red-700 me-3"
                @click="mostrarRegistros"
            >
                    <span>Registros</span>
            </Button>
        </div>
        <!-- <CardsDashBoard/> -->

    </AuthenticatedLayout>
</template>
<script setup>
    import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
    import GestionIngreso from '../Components/GestorCuentas/GestorIngreso.vue';
    import GestionGasto from '../Components/GestorCuentas/GestorGasto.vue';
    import RegistroCuentas from '../Components/Wallet/RegistrosCuentas.vue';
    import Button from '@/Components/Button.vue'
    import CardsDashBoard from '../Components/CardsDashBoard.vue';
    import UpdateBankInformationForm from '../Profile/Partials/UpdateBankInformationForm.vue';
    import FormCreateWallet from '../Components/Wallet/FormCreateWallet.vue';
    import Wallets from '../Components/Wallet/Wallets.vue';
</script>

<script>

export default {
    data() {
        return {
            showWallets: true,

        mostrarComponenteIngreso: false,
        mostrarComponenteGasto: false,
        mostrarComponenteRegistros: false,
        };
    },
    methods: {
        toggleComponent() {
            this.showWallets = !this.showWallets;
        },
        mostrarIngreso() {
        this.mostrarComponenteIngreso = true;
        this.mostrarComponenteGasto = false;
        this.mostrarComponenteRegistros = false;

        },
        mostrarGasto() {
        this.mostrarComponenteIngreso = false;
        this.mostrarComponenteGasto = true;
        this.mostrarComponenteRegistros = false;

        },
        mostrarRegistros() {
        this.mostrarComponenteIngreso = false;
        this.mostrarComponenteGasto = false;
        this.mostrarComponenteRegistros = true;
        },
    },
    components: {
        GestionIngreso,
        GestionGasto,
        RegistroCuentas,
        CardsDashBoard,
    },
    props: {
        walletTypes: Array,
        wallets: Array,
        userRoles: Array,
        categories: Array,
        sub_categories: Array,
        registros: Array,
        programRecords: Array,
        flash: { type: Object, default: () => [] }    
    },
    computed: {
        SuperAdminRole() {
            return this.userRoles.includes('SuperAdmin');
        },
    },
    mounted() {
    },
};
</script>