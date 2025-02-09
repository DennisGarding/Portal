export default class Category {
  constructor(id, name, type) {
    this.id = id
    this.name = name
    this.type = type
    this.links = []
    this.snippets = []
  }

  addLink(link) {
    this.links.push(link)
  }

  setLinks(links) {
    this.links = links
  }

  addSnippet(snippet) {
    this.snippets.push(snippet)
  }

  setSnippets(snippets) {
    this.snippets = snippets
  }
}
