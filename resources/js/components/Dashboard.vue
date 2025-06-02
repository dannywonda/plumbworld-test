<template>
    <section class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
        <div v-for="([key, value], index) in Object.entries(stats)" :key="key"
            class="flex items-center p-8 bg-white shadow rounded-lg mb-4">
            <div
                class="inline-flex flex-shrink-0 items-center justify-center h-16 w-16 text-blue-600 bg-blue-100 rounded-full mr-6">
                <!-- You can customize the SVG or add conditional icons based on key -->
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <div>
                <span class="block text-2xl font-bold">{{ value }}</span>
                <span class="block text-gray-500">{{ key.replace(/_/g, ' ').toUpperCase() }}</span>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useProductStore } from '@/stores/productStore';

const store = useProductStore();
const stats = ref({})

onMounted(async () => {
    await store.fetchProductStats();
    stats.value = store.stats;
});
</script>
