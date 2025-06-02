<template>
    <transition name="fade">
        <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center"
            style="background-color: rgba(0, 0, 0, 0.2);"
            @click.self="close">
            <div class="bg-white rounded-lg shadow-xl max-w-lg w-full p-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">
                        {{ title }}
                    </h2>
                    <button @click="close" class="text-gray-500 hover:text-red-500 text-xl font-bold">
                        &times;
                    </button>
                </div>

                <div class="text-gray-700">
                    <slot />
                </div>
            </div>
        </div>
    </transition>
</template>

<script setup>
const emit = defineEmits(['close', 'confirm']); // 💡 This line is REQUIRED
defineProps({
    show: Boolean,
    title: String,
}); 

const close = () => {
    emit("close");
};
</script>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: opacity 0.2s;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
}
</style>
