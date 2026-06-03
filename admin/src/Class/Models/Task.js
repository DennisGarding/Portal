export default class Task {
  constructor(id, name, description, priority, dueDate, status) {
    this.id = id
    this.name = name
    this.description = description
    this.priority = priority
    this.dueDate = dueDate
    this.status = status
  }
}
