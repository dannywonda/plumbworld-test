<template>
    <div>
        <section class="grid grid-cols-1 xl:grid-flow-col gap-6">
            <div class="row-span-3 bg-white shadow rounded-lg">
                <div
                    class="flex items-center justify-between px-6 py-5 font-semibold border-b border-gray-100"
                >
                    <span>Products List</span>
                </div>
                <div
                    class="p-4 -mb-2 py-4 flex flex-wrap flex-grow justify-between"
                >
                    <div class="flex items-center py-2">
                        <div class="relative inline-block text-left">
                            <button
                                @click="open = !open"
                                class="inline-flex justify-center w-full rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-500"
                                type="button"
                                aria-haspopup="true"
                                :aria-expanded="open.toString()"
                            >
                                Filters
                                <svg
                                    class="-mr-1 ml-2 h-5 w-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    fill="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M5.23 7.21a.75.75 0 011.06.02L10 11.293l3.71-4.06a.75.75 0 111.08 1.04l-4.25 4.656a.75.75 0 01-1.08 0L5.25 8.27a.75.75 0 01-.02-1.06z"
                                        clip-rule="evenodd"
                                    />
                                </svg>
                            </button>

                            <transition
                                enter-active-class="transition ease-out duration-100"
                                enter-from-class="transform opacity-0 scale-95"
                                enter-to-class="transform opacity-100 scale-100"
                                leave-active-class="transition ease-in duration-75"
                                leave-from-class="transform opacity-100 scale-100"
                                leave-to-class="transform opacity-0 scale-95"
                            >
                                <div
                                    v-if="open"
                                    class="origin-top-left absolute left-0 mt-2 w-72 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50 p-4"
                                >
                                    <input
                                        v-model="store.searchQuery"
                                        @input="store.debouncedFetch"
                                        placeholder="Search products..."
                                        class="w-full mb-3 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    />

                                    <select
                                        v-model="store.isActive"
                                        @change="store.debouncedFetch"
                                        class="w-full mb-3 px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                    >
                                        <option :value="null">
                                            All Statuses
                                        </option>
                                        <option :value="true">Active</option>
                                        <option :value="false">Inactive</option>
                                    </select>

                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <input
                                            type="number"
                                            v-model.number="store.minPrice"
                                            @input="store.debouncedFetch"
                                            placeholder="Min Price"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        />

                                        <input
                                            type="number"
                                            v-model.number="store.maxPrice"
                                            @input="store.debouncedFetch"
                                            placeholder="Max Price"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        />
                                    </div>

                                    <div class="grid grid-cols-2 gap-3">
                                        <input
                                            type="number"
                                            v-model.number="store.minStock"
                                            @input="store.debouncedFetch"
                                            placeholder="Min Stock"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        />

                                        <input
                                            type="number"
                                            v-model.number="store.maxStock"
                                            @input="store.debouncedFetch"
                                            placeholder="Max Stock"
                                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500"
                                        />
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>
                    <div class="flex items-center py-2">
                        <button
                            @click="openAddModal()"
                            class="inline-block px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:shadow-outline"
                        >
                            Create new product
                        </button>
                    </div>
                </div>

                <div class="-my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div
                        class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200"
                    >
                        <table class="min-w-full">
                            <thead>
                                <tr
                                    class="bg-gray-50 border-b border-gray-200 text-xs leading-4 text-gray-500 uppercase tracking-wider"
                                >
                                    <th class="px-6 py-3 text-left font-medium">
                                        <input
                                            class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                            type="checkbox"
                                        />
                                    </th>
                                    <th class="px-6 py-3 text-left font-medium">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 text-left font-medium">
                                        Description
                                    </th>
                                    <th class="px-6 py-3 text-left font-medium">
                                        Stock
                                    </th>
                                    <th class="px-6 py-3 text-left font-medium">
                                        Price
                                    </th>
                                    <th class="px-6 py-3 text-left font-medium">
                                        Status
                                    </th>

                                    <th
                                        class="px-6 py-3 text-left font-medium"
                                    ></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <tr
                                    v-for="product in store.products"
                                    :key="product.id"
                                >
                                    <td
                                        class="px-6 py-4 border-b border-gray-200"
                                    >
                                        <input
                                            class="form-checkbox h-4 w-4 text-indigo-600 transition duration-150 ease-in-out"
                                            type="checkbox"
                                        />
                                    </td>
                                    <td
                                        class="px-6 py-4 border-b border-gray-200"
                                    >
                                        {{ product.name }}
                                    </td>
                                    <td
                                        class="px-6 py-4 border-b border-gray-200"
                                    >
                                        {{ product.description }}
                                    </td>
                                    <td
                                        class="px-6 py-4 border-b border-gray-200"
                                    >
                                        {{ product.stock }}
                                    </td>
                                    <td
                                        class="px-6 py-4 border-b border-gray-200"
                                    >
                                        {{ priceFormatter(product.price) }}
                                    </td>
                                    <td
                                        class="px-6 py-4 border-b border-gray-200"
                                    >
                                        <span
                                            v-if="product.is_active"
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800"
                                            >Active</span
                                        >
                                        <span
                                            v-else
                                            class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800"
                                            >Not Active</span
                                        >
                                    </td>

                                    <td
                                        class="px-6 py-4 text-right border-b border-gray-200 text-sm font-medium"
                                    >
                                        <button
                                            @click="openEditModal(product)"
                                            class="inline-block px-4 mr-2 py-2 border border-transparent text-sm rounded-md text-white bg-orange-600 hover:bg-orange-500 focus:outline-none focus:shadow-outline"
                                        >
                                            Edit product
                                        </button>

                                        <button
                                            @click="deleteModal(product)"
                                            class="inline-block px-4 py-2 border border-transparent text-sm rounded-md text-white bg-red-500 hover:bg-red-500 focus:outline-none focus:shadow-outline"
                                        >
                                            Delete product
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div
                        class="mt-4 flex justify-center items-center space-x-2"
                    >
                        <button
                            :disabled="store.currentPage <= 1"
                            @click="store.changePage(store.currentPage - 1)"
                            class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
                        >
                            Previous
                        </button>

                        <span
                            >Page {{ store.currentPage }} of
                            {{ store.lastPage }}</span
                        >

                        <button
                            :disabled="store.currentPage >= store.lastPage"
                            @click="store.changePage(store.currentPage + 1)"
                            class="px-3 py-1 bg-gray-200 rounded disabled:opacity-50"
                        >
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Single dynamic Modal -->
        <Modal
            :show="showModal"
            :title="isEditing ? 'Edit Product' : 'Add Product'"
            @close="showModal = false"
        >
            <form
                @submit.prevent="handleSubmit"
                class="max-w-lg mx-auto p-6 bg-white rounded shadow space-y-6"
            >
                <div>
                    <label
                        for="name"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Name:</label
                    >
                    <input
                        type="text"
                        id="name"
                        v-model="product.name"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="name"
                        required
                    />
                </div>

                <div>
                    <label
                        for="description"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Description:</label
                    >
                    <input
                        type="text"
                        id="description"
                        v-model="product.description"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="description"
                        required
                    />
                </div>

                <div>
                    <label
                        for="price"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Price:</label
                    >
                    <input
                        type="number"
                        id="price"
                        v-model="product.price"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="price"
                        required
                    />
                </div>

                <div>
                    <label
                        for="stock"
                        class="block mb-2 text-sm font-medium text-gray-900"
                        >Stock:</label
                    >
                    <input
                        type="number"
                        id="stock"
                        v-model="product.stock"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                        placeholder="stock"
                        required
                    />
                </div>

                <div>
                    <label class="flex items-center space-x-2">
                        <span>Active:</span>
                        <input type="checkbox" v-model="product.is_active" />
                    </label>
                </div>

                <div class="flex justify-end gap-2 mt-6">
                    <button
                        @click="showModal = false"
                        type="button"
                        class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300"
                    >
                        Cancel
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                    >
                        Confirm
                    </button>
                </div>
            </form>
        </Modal>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import Modal from "../modals/Modal.vue";
import { useProductStore } from "@/stores/productStore";

const store = useProductStore();

const product = ref({
    id: null,
    name: "",
    description: "",
    price: 0,
    stock: 0,
    is_active: false,
});

const products = ref([]);
const showModal = ref(false);
const isEditing = ref(false);
const selectedProduct = ref(null);
const open = ref(false);

function priceFormatter(price) {
    return new Intl.NumberFormat("en-GB", {
        style: "currency",
        currency: "GBP",
        minimumFractionDigits: 2,
    }).format(price);
}

async function handleSubmit() {
    if (isEditing.value) {
        try {
            await store.updateProduct({ ...product.value });
        } catch (error) {
            console.error("Update failed", error);
        }
    } else {
        try {
            await store.addProduct({ ...product.value });
        } catch (error) {
            console.error("Add failed", error);
        }
    }

    showModal.value = false;
    resetForm();
}

function resetForm() {
    product.value = {
        id: null,
        name: "",
        description: "",
        price: 0,
        stock: 0,
        is_active: false,
    };
    isEditing.value = false;
}

function openAddModal() {
    isEditing.value = false;
    product.value = {
        id: null,
        name: "",
        description: "",
        price: 0,
        stock: 0,
        is_active: false,
    };
    showModal.value = true;
}

function openEditModal(prod) {
    isEditing.value = true;
    selectedProduct.value = prod;
    product.value = { ...prod };
    showModal.value = true;
}

function deleteModal(prod) {
    if (confirm(`Are you sure you want to delete the product: ${prod.name}?`)) {
        store
            .deleteProduct(prod.id)
            .then(() => {
                store.fetchProducts(); // Refresh the product list
            })
            .catch((error) => {
                console.error("Delete failed", error);
            });
    }
}

onMounted(async () => {
    await store.fetchProducts();
    products.value = store.products;
});
</script>
