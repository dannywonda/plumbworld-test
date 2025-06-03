// stores/productStore.js
import { defineStore } from 'pinia'
import axios from 'axios'
import debounce from 'lodash/debounce'

export const useProductStore = defineStore('productStore', {
    state: () => ({
        products: [],
        currentPage: 1,
        lastPage: 1,
        perPage: 12,
        searchQuery: '',
        isActive: null,
        minPrice: null,
        maxPrice: null,
        minStock: null,
        maxStock: null,
        loading: false,
        error: null,
        stats: {},
        debouncedFetch: null,
    }),

    actions: {
        async fetchProductStats() {
            this.loading = true
            this.error = null

            try {
                const res = await axios.get('/api/products/stats')
                this.stats = res.data || {}
            } catch (error) {
                this.error = error.message || 'Failed to fetch product stats'
                return {}
            } finally {
                this.loading = false
            }
        },

        async fetchProducts(page = 1) {
            this.loading = true
            this.error = null

            try {
                 const params = { page }

                if (this.searchQuery.trim() !== '') {
                    params.name = this.searchQuery.trim()
                }
                if (this.isActive !== null) {
                    params.is_active = this.isActive ? 1 : 0
                }
                if (this.minPrice !== null) {
                    params.min_price = this.minPrice
                }
                if (this.maxPrice !== null) {
                    params.max_price = this.maxPrice
                }
                if (this.minStock !== null) {
                    params.min_stock = this.minStock
                }
                if (this.maxStock !== null) {
                    params.max_stock = this.maxStock
                }

                const res = await axios.get('/api/products', { params })
                this.products = res.data.data || []

                this.currentPage = res.data.meta.current_page
                this.lastPage = res.data.meta.last_page
                this.perPage = res.data.meta.per_page

                console.log('Products fetched:', this.products);

            } catch (error) {
                this.error = error.message || 'Failed to fetch products'
            } finally {
                this.loading = false
            }
        },

        changePage(page) {
            if (page < 1 || page > this.lastPage) return;
            this.fetchProducts(page);
        },

        debouncedFetch: debounce(function () {
            this.fetchProducts()
        }, 300),

        async addProduct(product) {
            this.loading = true
            try {
                const res = await axios.post('/api/products', product)
                this.products.unshift(res.data.data)
            } catch (error) {
                this.error = error.message || 'Failed to add product'
            } finally {
                this.loading = false
            }
        },

        async updateProduct(product) {
            this.loading = true
            try {
                const res = await axios.put(`/api/products/${product.id}`, product)
                const index = this.products.findIndex(p => p.id === product.id)
                if (index !== -1) {
                    this.products[index] = res.data.data
                }
            } catch (error) {
                this.error = error.message || 'Failed to update product'
            } finally {
                this.loading = false
            }
        },

        async deleteProduct(id) {
            this.loading = true
            try {
                alert('red');
                await axios.delete(`/api/products/${id}`)
                this.products = this.products.filter(p => p.id !== id)
            } catch (error) {
                this.error = error.message || 'Failed to delete product'
            } finally {
                this.loading = false
            }
        }
    }
})
