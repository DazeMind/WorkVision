<template>
  <AuthenticatedLayout title="Dashboard">
    <template #header>
      <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
        <h2 class="text-xl font-semibold leading-tight">
          Gestor de Billeteras
        </h2>
      </div>
    </template>

    <div class="p-6 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1">
      <Button
        v-if="SuperAdminRole"
        external
        variant="black"
        class="items-center gap-2 max-w-xs bg-blue-700"
        href=""
        @click="toggleFormCreateWallet"
      >
        {{ mostrarComponenteFormCreateWallet ? 'Contraer formulario' : 'Crear nueva billetera' }}
      </Button>
    </div>

    <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
      <p class="text-lg font-semibold leading-tight mb-3">
        Mis Billeteras
      </p>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-8">
        <div v-for="(wallet, index) in wallets" :key="index" class="p-2 bg-neutral-100 shadow-lg dark:bg-neutral-900 rounded-2xl border border-gray-200 dark:border-gray-700">
          <div class="flex items-center justify-center">
            <svg data-slot="icon" fill="none" stroke-width="1" stroke="black" width="30" height="30" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a2.25 2.25 0 0 0-2.25-2.25H15a3 3 0 1 1-6 0H5.25A2.25 2.25 0 0 0 3 12m18 0v6a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 18v-6m18 0V9M3 12V9m18 0a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 9m18 0V6a2.25 2.25 0 0 0-2.25-2.25H5.25A2.25 2.25 0 0 0 3 6v3"></path>
            </svg>  
            <h2 class="ps-2">{{ wallet.name }}</h2>
          </div>
          <div class="w-full md:w-[360px] flex flex-col py-2 rounded-xl overflow-hidden bg-neutral-10 dark:bg-neutral-900">
            <div class="min-h-[3.5rem] flex flex-row items-center gap-4 py-2 pl-4 pr-6">
              <div class="w-9 h-9 flex items-center justify-center title-md font-bold bg-primary-600 text-white dark:bg-primary-200 dark:text-neutral-900">
                <svg data-slot="icon" width="30" height="30" fill="none" stroke-width="1.5" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"></path>
                </svg>                      
              </div>
              <div class="me-4">
                <p class="tracking-[.03125em]">Ingresos</p>
              </div>
                <span class="text-[15px] leading-4 tracking-[.045em] font-medium">$ {{wallet.amount.toLocaleString()}}</span>
            </div>
            <div class="flex flex-row items-center gap-4 py-2 pl-4 pr-6">
              <div class="w-9 h-9 flex items-center justify-center title-md font-bold bg-primary-600 text-white dark:bg-primary-200 dark:text-neutral-900">
                <svg data-slot="icon" width="30" height="30" fill="none" stroke-width="1.5" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18 9 11.25l4.306 4.306a11.95 11.95 0 0 1 5.814-5.518l2.74-1.22m0 0-5.94-2.281m5.94 2.28-2.28 5.941"></path>
                </svg>                      
              </div>
              <div class="me-4">
                <p class="tracking-[.03125em]">Gastos</p>
              </div>
                <span class="text-[15px] leading-4 tracking-[.045em] font-medium">$ {{wallet.amount.toLocaleString()}}</span>
            </div>
            <div class="flex flex-row items-center gap-4 py-2 pl-4 pr-6">
              <div class="w-9 h-9 flex items-center justify-center title-md font-bold bg-primary-600 text-white dark:bg-primary-200 dark:text-neutral-900">
                <svg data-slot="icon" width="30" height="30" fill="none" stroke-width="1.5" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181"></path>
                </svg>                      
              </div>
              <div class="me-4">
                <p class="tracking-[.03125em]">Tipo</p>
              </div>
              <span class="text-[15px] leading-4 tracking-[.1em] font-medium">{{ getTypeName(wallet.id_type) }}</span>
            </div>
          </div>
          <div class="flex flex-row items-center gap-4 py-2 pl-4 pr-6">
            <div class="w-9 h-9 flex items-center justify-center title-md font-bold bg-primary-600 text-white dark:bg-primary-200 dark:text-neutral-900">
              <svg data-slot="icon" width="30" height="30" fill="none" stroke-width="1.5" stroke="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z"></path>
              </svg>                      
            </div>
            <div class="me-4">
              <p class="tracking-[.03125em]">Saldo</p>
            </div>
            <span class="text-[16px] leading-4 tracking-[0.045em] font-medium">${{wallet.amount.toLocaleString()}}</span>
          </div>
                <div class="min-h-[3.5rem] flex flex-row items-center gap-4 py-2 pl-4 pr-6">
                  <div class="flex flex-col flex-grow">
                    <p class="tracking-[.03125em] text-center hover:text-sky-500" >Ver Más</p>
                  </div>
                </div>
        </div>
      </div>
    </div>

    <div v-if="mostrarComponenteFormCreateWallet">
    <div class="p-5 overflow-hidden bg-white rounded-md shadow-md dark:bg-dark-eval-1 mt-5" id="Billeteras">
        <div class="card">
          <FormCreateWallet :walletTypes="walletTypes" />
        </div>
      </div>
    </div>
    

  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/Authenticated.vue';
import FormCreateWallet from '../../Components/Wallet/FormCreateWallet.vue';
import Button from '@/Components/Button.vue';
</script>

<script>
export default {
  data() {
    return {
      mostrarComponenteFormCreateWallet: false,
    };
  },
  methods: {
    toggleFormCreateWallet() {
      this.mostrarComponenteFormCreateWallet = !this.mostrarComponenteFormCreateWallet;
    },
    getTypeName(idType) {
      const type = this.walletTypes.find(type => type.id === idType);
      return type ? type.name : 'Desconocido';
    },
  },
  components: {
    FormCreateWallet,
  },
  props: {
    userRoles: Array,
    walletTypes: Array,
    wallets: Array,
  },
  computed: {
    SuperAdminRole() {
      return this.userRoles.includes('SuperAdmin');
    },
  },
  mounted() {
    console.log("Categorías recibidas:", this.categories);
  },
};
</script>