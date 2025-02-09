import axios from 'axios'
import Snippet from '@/Class/Models/Snippet.js'

export default class SnippetRepository {
  constructor(mainStore) {
    this.client = axios
    this.mainStore = mainStore
  }

  loadSnippet(id) {
    return this.client
      .get(`/call/snippet/load/${id}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  loadSnippets() {
    return this.client
      .get(`/call/snippet/load`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data)
      })
  }

  saveSnippet(snippet) {
    if (!(snippet instanceof Snippet)) {
      return Promise.reject('Provided data needs to be an instance of Snippet')
    }

    let method = 'create'
    if (snippet.id) {
      method = 'update'
    }

    this.mainStore.setLoading()

    return this.client
      .post(`/call/snippet/${method}`, snippet)
      .then((response) => {
        this.mainStore.unsetLoading()

        return response.data
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  deleteSnippet(snippetId) {
    this.mainStore.setLoading()

    return this.client
      .delete(`/call/snippet/delete/${snippetId}`)
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
