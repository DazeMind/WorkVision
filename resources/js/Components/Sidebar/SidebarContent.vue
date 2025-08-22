<script setup>
import PerfectScrollbar from '@/Components/PerfectScrollbar.vue'
import SidebarLink from '@/Components/Sidebar/SidebarLink.vue'
import { DashboardIcon } from '@/Components/Icons/outline'
import SidebarCollapsible from '@/Components/Sidebar/SidebarCollapsible.vue'
import SidebarCollapsibleItem from '@/Components/Sidebar/SidebarCollapsibleItem.vue'
import { CalculatorIcon, ClipboardListIcon,FolderIcon,ShoppingBagIcon, CurrencyDollarIcon, UserGroupIcon } from '@heroicons/vue/outline'
import { ShoppingCartIcon } from '@heroicons/vue/solid'
</script>
<script>
export default {
    data() {
        return {
            userCompanies: this.$page.props.auth.userCompanies,
            hasOrdersSalesCompany:null
        };
    },
    methods: {
        isActive(routeName, params = {}) {
            return route().current(routeName, params);
        },
        checkOrdersSalesCompany() {
            this.hasOrdersSalesCompany = this.userCompanies.some(company => company.type === "orders/sales");
        }
    },
    mounted(){
        this.checkOrdersSalesCompany();
        // console.log("Page Props",this.$page.props);
    }
};
</script>
<template>
    <PerfectScrollbar
        tagname="nav"
        aria-label="main"
        class="relative flex flex-col flex-1 max-h-full gap-4 px-3"
    >
        <SidebarLink
            title="Dashboard"
            :href="route('dashboard')"
            :active="route().current('dashboard')"
        >
            <template #icon>
                <DashboardIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>
        <SidebarLink
            title="Colaboradores"
            :href="route('worker.create')"
            :active="route().current('worker.*')"
        >
            <template #icon>
                <UserGroupIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>
        <div v-if="$page.props.auth.userCompanies">
            <SidebarLink
                v-if="hasOrdersSalesCompany"
                title="Pedidos / Ventas"
                :href="route('OrdersSales')"
                :active="route().current('OrdersSales')"
            >
                <template #icon>
                    <ShoppingBagIcon
                        class="flex-shrink-0 w-6 h-6"
                        aria-hidden="true"
                    />
                </template>
            </SidebarLink>
            <SidebarLink
                v-if="!hasOrdersSalesCompany"
                title="Proyectos"
                :href="route('proyect.index')"
                :active="route().current('proyect.index')"
            >
                <template #icon>
                    <FolderIcon
                        class="flex-shrink-0 w-6 h-6"
                        aria-hidden="true"
                    />
                </template>
            </SidebarLink>
         </div>
        <!-- <SidebarLink
            title="Inventarios"
            :href="route('inventarios')"
            :active="route().current('inventarios')"
        >
            <template #icon>
                <ClipboardListIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink> -->
        <SidebarCollapsible
            title="Inventarios"
            :active="route().current('inventarios*') || route().current('products*')"
        >
            <template #icon>
                <ClipboardListIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
            <SidebarCollapsibleItem v-if="hasOrdersSalesCompany"
                :href="route('products')"
                title="Productos / Servicios"
                :active="route().current('products')"
            />
            <SidebarCollapsibleItem
                :href="route('inventarios')"
                title="Inventario"
                :active="route().current('inventarios')"
            />
            <SidebarCollapsibleItem
                :href="route('inventarios.stock')"
                title="Stock"
                :active="route().current('inventarios.stock')"
            />
            <!-- <SidebarCollapsibleItem
                :href="route('components.buttons')"
                title="Configuraciones"
                :active="route().current('components.buttons')"
            /> -->
        </SidebarCollapsible>
        <SidebarLink
            title="Finanzas"
            :href="route('Cuentas')"
            :active="route().current('Cuentas')"
        >
            <template #icon>
                <CurrencyDollarIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
        </SidebarLink>
        <SidebarCollapsible
            title="Crear Clientes"
            :active="route().current('cuentas.*')"
            v-if="$page.props.auth.is_admin"
        >
            <template #icon>
                <CalculatorIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>

            <SidebarCollapsibleItem
                :href="route('Cuentas')"
                title="Ingreso/Gasto"
                :active="route().current('Cuentas')"
            />
            <SidebarCollapsibleItem
                :href="route('wallet')"
                title="Billetera"
                :active="route().current('wallet')"
            />
            <!-- <SidebarCollapsibleItem
                :href="route('components.buttons')"
                title="Configuraciones"
                :active="route().current('components.buttons')"
            /> -->
        </SidebarCollapsible>
        <!-- Examples -->
        <!--
        => External link example
        <SidebarLink
            title="Github"
            href="https://github.com/kamona-wd/kui-laravel-breeze"
            external
            target="_blank"
        >
        </SidebarLink>

        => Collapsible examples
        <SidebarCollapsible title="Users" :active="$page.url.startsWith('/users')">
            <SidebarCollapsibleItem :href="route('users.index')" title="List" :active="$page.url === '/users/index'" />
            <SidebarCollapsibleItem :href="route('users.create')" title="Create" :active="$page.url === '/users/create'" />
        </SidebarCollapsible>

        <SidebarCollapsible title="Users" :active="usePage().url.value.startsWith('/users')">
            <template #icon>
                <UserIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>

            <SidebarCollapsibleItem :href="route('users.index')" title="List" :active="route().current('users.index')" />
            <SidebarCollapsibleItem :href="route('users.create')" title="Create" :active="route().current('users.create')" />
        </SidebarCollapsible>-->
    </PerfectScrollbar>
</template>
