import axios from 'axios'
import Task from '@/Class/Models/Task.js'
import {DateFormater} from "@/Services/DateTimeFormatter.js";

export default class TaskRepository {
  constructor(mainStore) {
    this.client = axios
    this.mainStore = mainStore
  }

  loadTask(id) {
    this.mainStore.setLoading()

    return this.client
      .get(`/call/task/load/${id}`)
      .then((response) => {
        this.mainStore.unsetLoading()

        return this.__createTask(response.data)
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  loadTasks() {
    this.mainStore.setLoading()

    return this.client
      .get(`/call/task/load`)
      .then((response) => {
        const taskList = []

        response.data.forEach((task) => {
          taskList.push(this.__createTask(task))
        })

        this.mainStore.unsetLoading()

        return taskList
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  saveTask(task) {
    if (!(task instanceof Task)) {
      return Promise.reject('Provided data needs to be an instance of Task')
    }

    let method = 'create'
    if (task.id) {
      method = 'update'
    }

    if (task.dueDate) {
      task.dueDate = new Date(task.dueDate)
    }

    this.mainStore.setLoading()

    return this.client
      .post(`/call/task/${method}`, task)
      .then((response) => {
        this.mainStore.unsetLoading()

        return this.__createTask(response.data)
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  moveTask(taskId, targetStatus) {
    this.mainStore.setLoading()

    return this.client
      .post(`/call/task/move/${taskId}`, {targetStatus: targetStatus})
      .then(() => {
        this.mainStore.unsetLoading()
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  deleteTask(taskId) {
    this.mainStore.setLoading()

    return this.client
      .delete(`/call/task/delete/${taskId}`)
      .then(() => {
        this.mainStore.unsetLoading()
      })
      .catch((error) => {
        this.mainStore.unsetLoading()

        return Promise.reject(error.response.data.error)
      })
  }

  __createTask(taskData) {
    let dueDate = null;
    if (taskData.dueDate) {
      dueDate = DateFormater.formateForHtml(taskData.dueDate)
    }

    return new Task(
      taskData.id,
      taskData.name,
      taskData.description,
      taskData.priority,
      dueDate || taskData.dueDate,
      taskData.status,
    )
  }
}
