<script>
import VCodeBlock from '@wdns/vue-code-block'
import 'prismjs/plugins/line-numbers/prism-line-numbers.js'
import 'prismjs/plugins/line-numbers/prism-line-numbers.css'

export default {
  name: 'CodeBlock',
  components: { VCodeBlock },

  props: {
    code: {
      type: String,
      required: true,
      default: '',
    },

    lang: {
      type: String,
      default: 'php'
    },
  },

  computed: {
    translateCodeType() {
      let lang = 'javascript'
      switch (this.lang) {
        case 'javascript':
        case 'typescript':
        case 'php':
        case 'sql':
        case 'json':
        case 'yaml':
          lang = 'javascript'
          break;
        case 'html':
        case 'twig':
          lang = 'html'
          break;
        case 'css':
        case 'less':
        case 'scss':
          lang = 'css'
          break;
        default:
          lang = 'javascript'
      }

      return lang;
    }
  }
}
</script>

<template>

    <v-code-block
      class="line-numbers"
      codeBlockRadius="0"
      :code="code"
      :label="Code"
      :lang="translateCodeType"
      theme="themes-night-owl"
      prismjs
      persistent-copy-button
    />

</template>

<style scoped></style>
