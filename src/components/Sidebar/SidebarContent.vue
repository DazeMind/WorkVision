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
                aria-hidden="true  "   
            />
        </template>
    </SidebarLink>
    <SidebarCollapsible 
        title="Clientes"
        :active="route().current('clientes')">
        <template #icon>
            <UsersIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
        <SidebarCollapsibleItem 
            title="Inicio"
            :href="route('clients.index')"
            :active="route().current('clientes')" >
        </SidebarCollapsibleItem>
        <SidebarCollapsibleItem 
            title="Crear cliente"
            :href="route('clients.create')"
            :active="route().current('clientes')" >
        </SidebarCollapsibleItem>
    </SidebarCollapsible>
    <SidebarCollapsible 
        title="Config_Price"
        :active="route().current('config_price')">
        <template #icon>
            <UsersIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
        <SidebarCollapsibleItem 
            title="Crear Confir_price"
            :href="route('config_price.create')"
            :active="route().current('config_price.create')" >
        </SidebarCollapsibleItem>
    </SidebarCollapsible>
    <SidebarCollapsible 
        title="Proovedor"
        :active="route().current('proovedor.create')">
        <template #icon>
            <UsersIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
        <SidebarCollapsibleItem 
            title="Crear Proovedor"
            :href="route('proovedor.create')"
            :active="route().current('proovedor.create')" >
        </SidebarCollapsibleItem>
    </SidebarCollapsible>
    <SidebarCollapsible title="Products" >
        <template #icon>
            <UsersIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
        <SidebarCollapsibleItem 
            title="Crear producto"
            :href="route('product.create')"
            :active="route().current('product.create')" >
        </SidebarCollapsibleItem>
        <SidebarCollapsibleItem 
            title="Ver Productos"
            :href="route('product.index')"
            :active="route().current('product.index')" >
        </SidebarCollapsibleItem>
        <SidebarCollapsibleItem 
            title="Crear imagenes de producto"
            :href="route('product.index')"
            :active="route().current('product.index')" >
        </SidebarCollapsibleItem>
        <SidebarCollapsibleItem 
            title="Ver imagenes de producto"
            :href="route('product.index')"
            :active="route().current('product.index')" >
        </SidebarCollapsibleItem>
    </SidebarCollapsible>

    <SidebarLink title="Precios" :href="route('dashboard')" :active="route().current('precios')">
        <template #icon>
            <DashboardIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
    </SidebarLink>
    <SidebarLink title="Stock" :href="route('dashboard')" :active="route().current('stock')">
        <template #icon>
            <DashboardIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
    </SidebarLink>
    <SidebarLink title="Ordenes" :href="route('dashboard')" :active="route().current('ordenes')">
        <template #icon>
            <DashboardIcon
                class="flex-shrink-0 w-6 h-6"
                aria-hidden="true"
            />
        </template>
    </SidebarLink>
    <SidebarLink title="Carga masiva" :href="route('file.inicio')" :active="route().current('file.inicio')" >
            <template #icon>
                <DashboardIcon
                    class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true"
                />
            </template>
    </SidebarLink>

    <SidebarCollapsible title="Catalogo" :active="route().current('tag')">
        <template #icon>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" strokeWidth={1.5} stroke="currentColor"  class="flex-shrink-0 w-6 h-6"
                    aria-hidden="true">
                <path strokeLinecap="round" strokeLinejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </template>
        <SidebarCollapsible title="Product_variant_type" :active="route().current('product_variant_type')">
            <SidebarCollapsibleItem 
                title="Crear Product_variant_type"
                :href="route('product_variant_type.create')"
                :active="route().current('product_variant_type.create')" >
            </SidebarCollapsibleItem>
            <SidebarCollapsibleItem 
                title="Ver Product_variant_type"
                :href="route('product_variant_type.index')"
                :active="route().current('product_variant_type.index')" >
            </SidebarCollapsibleItem>
        </SidebarCollapsible>
        <SidebarCollapsible title="Tag" :active="route().current('tag')">
            <SidebarCollapsibleItem 
                title="Crear tag"
                :href="route('tag.create')"
                :active="route().current('tag.create')" >
            </SidebarCollapsibleItem>
            <SidebarCollapsibleItem 
                title="Ver tag"
                :href="route('tag.index')"
                :active="route().current('tag.index')" >
            </SidebarCollapsibleItem>
        </SidebarCollapsible>
        <SidebarCollapsible title="Product_type" :active="route().current('product_type')">
            <SidebarCollapsibleItem 
                title="Crear product_type"
                :href="route('product_type.create')"
                :active="route().current('product_type.create')" >
            </SidebarCollapsibleItem>
            <SidebarCollapsibleItem 
                title="Ver product_type"
                :href="route('product_type.index')"
                :active="route().current('product_type.index')" >
            </SidebarCollapsibleItem>
        </SidebarCollapsible>
        <SidebarCollapsible title="Brand" :active="route().current('brand')">
            <SidebarCollapsibleItem 
                title="Crear Brand"
                :href="route('brand.create')"
                :active="route().current('brand.create')" >
            </SidebarCollapsibleItem>
            <SidebarCollapsibleItem 
                title="Ver Brand"
                :href="route('brand.index')"
                :active="route().current('brand.index')" >
            </SidebarCollapsibleItem>
        </SidebarCollapsible>
        <SidebarCollapsible title="Collection" :active="route().current('collection')">
            <SidebarCollapsibleItem 
                title="Crear Collection"
                :href="route('collection.create')"
                :active="route().current('collection.create')" >
            </SidebarCollapsibleItem>
            <SidebarCollapsibleItem 
                title="Ver Collection"
                :href="route('collection.index')"
                :active="route().current('collection.index')" >
            </SidebarCollapsibleItem>
        </SidebarCollapsible>
    </SidebarCollapsible>

    </PerfectScrollbar>
</template>

<script setup>
import PerfectScrollbar from '@/Components/PerfectScrollbar'
import SidebarLink from '@/Components/Sidebar/SidebarLink.vue'
import { DashboardIcon } from '@/Components/Icons/Outline'
import SidebarCollapsible from './SidebarCollapsible.vue';
import SidebarCollapsibleItem from './SidebarCollapsibleItem.vue';
import { UsersIcon } from '@heroicons/vue/outline';
</script>
