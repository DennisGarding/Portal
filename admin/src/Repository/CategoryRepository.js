import axios from 'axios'
import Category from '@/Class/Models/Category.js'
import Link from '@/Class/Models/Link.js'
import Snippet from '@/Class/Models/Snippet.js'

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
        const category = this.__createCategory(response.data)

        this.mainStore.unsetLoading()

        return category
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
        const categoryArray = []

        response.data.forEach((categoryData) => {
          console.log(categoryData)
          categoryArray.push(this.__createCategory(categoryData))
        })

        this.mainStore.unsetLoading()

        return categoryArray
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
        const categoryArray = []

        response.data.forEach((categoryData) => {
          categoryArray.push(this.__createCategory(categoryData, type))
        })

        this.mainStore.unsetLoading()

        return categoryArray
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

        return this.__createCategory(response.data)
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
      .then(() => {
        this.mainStore.unsetLoading()
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  __createCategory(categoryData, type = '') {
    const category = new Category(categoryData.id, categoryData.name, categoryData.type)

    if (type === 'link') {
      categoryData.links.forEach((link) => {
        category.addLink(new Link(link.id, link.categoryId, link.name, link.url))
      })
    }

    if (type === 'snippet') {
      categoryData.snippets.forEach((snippet) => {
        category.addSnippet(
          new Snippet(
            snippet.id,
            snippet.name,
            snippet.description,
            snippet.code,
            snippet.type,
            snippet.categoryId,
          ),
        )
      })
    }

    return category
  }
}
