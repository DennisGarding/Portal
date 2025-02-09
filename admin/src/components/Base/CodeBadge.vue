<script>
export default {
  name: 'CodeBadge',

  props: {
    type: {
      type: String,
      required: true,
    },
  },

  computed: {
    getLabel() {
      let label = ''
      switch (this.type) {
        case 'php':
          label = 'PHP'
          break
        case 'sql':
          label = 'SQL'
          break
        case 'javascript':
          label = 'JavaScript'
          break
        case 'typescript':
          label = 'TypeScript'
          break
        case 'html':
          label = 'HTML'
          break
        case 'twig':
          label = 'Twig'
          break
        case 'css':
          label = 'CSS'
          break
        case 'less':
          label = 'Less'
          break
        case 'scss':
          label = 'Sass'
          break
        case 'yaml':
          label = 'YAML'
          break
        case 'json':
          label = 'JSON'
          break
        case 'other':
          label = 'Other'
          break
      }

      return label
    },

    langClass() {
      return `lang-${this.type}`
    },
  },
}
</script>

<template>
  <div class="badge code-pill" :class="langClass">{{ getLabel }}</div>
</template>

<style scoped></style>
