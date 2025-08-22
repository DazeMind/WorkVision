<script setup>
  import Button from '@/Components/Button.vue'
  import { UserGroupIcon, TrashIcon,FolderIcon,CurrencyDollarIcon } from '@heroicons/vue/outline';
  import Swiper from 'swiper';
  import 'swiper/swiper-bundle.css';
</script>
<script>
  export default {
    props: {
      walletTypes: Array,
      wallets: Array,
    },
    data() {
      return {
        formData: {
          walletTypes:  "",
          name:  "",
          amount:  "",
          color: "",
          numberAccount: "",
          date: new Date().toISOString().slice(0, 10), // Establecer la fecha actual
        },
      };
    },
    methods: {
      async enviarFormulario() {
          const requestData = {
              formData: this.formData,
          };
          const response = await this.$inertia.post('wallet',requestData);
      },
      async deleteWallet(wallet) {
          const confirmation = confirm(`¿Estás seguro de eliminar la billetera ${wallet.name}?`);
          if (confirmation) {
              const response = await this.$inertia.delete(`/wallet/${wallet.id}`);
          }
      }
    },
    mounted() {
        this.swiper = new Swiper('.swiper-container', {
          slidesPerView: 1.4, // Por defecto para pantallas muy pequeñas
          spaceBetween: 5, // Espaciado entre elementos
          grabCursor: true, // Permite arrastrar con el mouse
          loop: this.wallets.length > 2, // Activar el loop solo si hay suficientes slides
          breakpoints: {
            640: { // Pantallas pequeñas
              slidesPerView: 1.7,
              spaceBetween: 15,
            },
            768: { // Pantallas medianas
              slidesPerView: 2.2,
              spaceBetween: 15,
            },
            1024: { // Pantallas grandes
              slidesPerView: 2.5,
              spaceBetween: 25,
            },
            1280: { // Pantallas extra grandes
              slidesPerView: 2.5,
              spaceBetween: 30,
            }
          }
        });
    }
  };
</script>

<template>
  <div class="swiper-container ms-4">
    <p class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4">
        Información general de la Billetera
    </p>
    <div class="swiper-wrapper">
      <div v-for="(wallet, index) in wallets" :key="wallet.id" class="swiper-slide mb-8">
        <div class="relative w-full max-w-sm p-6 rounded-2xl shadow-lg transition-transform transform hover:-translate-y-1 hover:shadow-2xl dark:border dark:border-gray-700" :style="{ backgroundColor: wallet.color }">        
          <div class="flex items-center justify-between mb-4">
            <h5 class="text-lg font-semibold text-gray-900 dark:text-white">
              {{ wallet.name }}
            </h5>
            <TrashIcon
              class="h-6 w-6 text-red-500 cursor-pointer hover:text-red-600"
              @click="deleteWallet(wallet)"
            />
          </div>
          <ul class="my-4 space-y-4">
            <li>
              <div
                class="flex items-center justify-between p-4 
                      rounded-lg bg-white/70 dark:bg-gray-700 
                      hover:bg-white dark:hover:bg-gray-600 
                      shadow-sm group transition-colors"
              >
                <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                  <CurrencyDollarIcon aria-hidden="true" class="w-5 h-5" />
                  <span class="font-medium">Saldo</span>
                </div>
                <span
                  class="px-3 py-1 text-sm font-semibold text-gray-700 
                        bg-gray-200 rounded dark:bg-gray-800 
                        dark:text-gray-300"
                >
                  {{ wallet.amount }}
                </span>
              </div>
            </li>
            <li>
              <a
                :href="route('proyect.index')" 
                class="flex items-center justify-between p-4 
                      rounded-lg bg-white/70 dark:bg-gray-700 
                      hover:bg-white dark:hover:bg-gray-600 
                      shadow-sm group transition-colors"
              >
                <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                  <FolderIcon aria-hidden="true" class="w-5 h-5" />
                  <span class="font-medium">Ingresado</span>
                </div>
                <span
                  class="px-3 py-1 text-sm font-semibold text-gray-700 
                        bg-gray-200 rounded dark:bg-gray-800 
                        dark:text-gray-300"
                >
                  {{ wallet.records.reduce((total, inc) => { return inc.type === 'income' ? total + inc.amount : total;}, 0) }}
                </span>
              </a>
            </li>
            <li>
              <a
                :href="route('worker.create')" 
                class="flex items-center justify-between p-4 
                      rounded-lg bg-white/70 dark:bg-gray-700 
                      hover:bg-white dark:hover:bg-gray-600 
                      shadow-sm group transition-colors"
              >
                <div class="flex items-center space-x-2 text-gray-700 dark:text-gray-300">
                  <UserGroupIcon aria-hidden="true" class="w-5 h-5" />
                  <span class="font-medium">Gasto</span>
                </div>
                <span
                  class="px-3 py-1 text-sm font-semibold text-gray-700 
                        bg-gray-200 rounded dark:bg-gray-800 
                        dark:text-gray-300"
                >
                {{ wallet.records.reduce((total, inc) => { return inc.type === 'expense' ? total + inc.amount : total;}, 0) }}
              </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>





    


  