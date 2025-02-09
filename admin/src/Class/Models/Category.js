export default class Category {
  constructor(id, name, type, links = [], snippets = [], ) {
    this.id = id
    this.name = name
    this.type = type
    this.links = links
    this.snippets = snippets
  }

  addLink(link) {
    this.links.push(link)
  }

  addSnippet(snippet) {
    this.snippets.push(snippet)
  }
}
