import axios from 'axios'
import Note from '@/Class/Models/Note.js'

export default class NoteRepository {
  constructor(mainStore) {
    this.client = axios
    this.mainStore = mainStore
  }

  loadNote(id) {
    this.mainStore.setLoading()

    return this.client
      .get(`/call/note/load/${id}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return this.__createNote(response.data)
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  saveNote(note) {
    if (!(note instanceof Note)) {
      return Promise.reject('Provided data needs to be an instance of Note')
    }

    let method = 'create'
    if (note.id) {
      method = 'update'
    }

    this.mainStore.setLoading()

    return this.client
      .post(`/call/note/${method}`, note)
      .then((response) => {
        this.mainStore.unsetLoading()

        return this.__createNote(response.data)
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  deleteNote(noteId) {
    this.mainStore.setLoading()

    return this.client
      .delete(`/call/note/delete/${noteId}`)
      .then(() => {
        this.mainStore.unsetLoading()
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  __createNote(noteData) {
    return new Note(noteData.id, noteData.name, noteData.note, noteData.categoryId)
  }
}
