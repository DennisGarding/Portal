export default class Category {
  constructor(id, name, type, links = [], snippets = [], notes = []) {
    this.id = id
    this.name = name
    this.type = type
    this.links = links
    this.snippets = snippets
    this.notes = notes
  }

  addLink(link) {
    this.links.push(link)
  }

  addSnippet(snippet) {
    this.snippets.push(snippet)
  }

  addNote(note) {
    this.notes.push(note)
  }
}
