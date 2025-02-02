import axios from 'axios'
import Link from '@/Class/Models/Link.js'

export default class LinkRepository {
  constructor(mainStore) {
    this.client = axios
    this.mainStore = mainStore
  }

  loadLink(id) {
    this.mainStore.setLoading()

    return this.client
      .get(`/call/link/load/${id}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data)
      })
  }

  saveLink(link) {
    if (!(link instanceof Link)) {
      return Promise.reject('Provided data needs to be an instance of Link')
    }

    let method = 'create'
    if (link.id) {
      method = 'update'
    }

    this.mainStore.setLoading()

    return this.client
      .post(`/call/link/${method}`, link)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data)
      })
  }

  moveLink(linkId, categoryId) {
    this.mainStore.setLoading()

    return this.client
      .post('/call/link/move', { id: linkId, categoryId: categoryId })
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data)
      })
  }

  deleteLink(linkId) {
    this.mainStore.setLoading()

    return this.client
      .delete(`/call/link/delete/${linkId}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data)
      })
  }
}
