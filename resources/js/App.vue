<template>
    <main class="p-6 sm:p-10 space-y-6">
        <div
            class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between"
        >
            <div class="mr-6">
                <h1 class="text-4xl font-semibold mb-2">Products</h1>
                <h2 class="text-gray-600 ml-0.5">There are (0) number of products</h2>
            </div>
        </div>
        <DashboardStats />
        <ProductTable />
    </main>
</template>

<script setup>
import ProductTable from "./components/products/ProductTable.vue";
import DashboardStats from "./components/Dashboard.vue";
</script>
