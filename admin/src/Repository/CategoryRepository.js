import axios from 'axios'
import Category from '@/Class/Models/Category.js'

export default class CategoryRepository {
  constructor(mainStore) {
    this.client = axios
    this.mainStore = mainStore
  }

  loadCategory(id) {
    this.mainStore.setLoading()

    return this.client
      .get(`/call/category/load/${id}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  loadCategories() {
    this.mainStore.setLoading()

    return this.client
      .get('/call/category/load')
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  loadCategoriesByType(type) {
    this.mainStore.setLoading()

    return this.client
      .get(`/call/category/load/by/${type}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  saveCategory(category) {
    if (!(category instanceof Category)) {
      return Promise.reject('Category is not an instance of Category')
    }

    let method = 'create'
    if (category.id) {
      method = 'update'
    }

    this.mainStore.setLoading()

    return this.client
      .post(`/call/category/${method}`, category)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  deleteCategory(categoryId) {
    this.mainStore.setLoading()

    return this.client
      .delete(`/call/category/delete/${categoryId}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }
}
