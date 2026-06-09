<script>
import ContentContainer from '@/components/Base/ContentContainer.vue'
import PageHead from '@/components/Base/PageHead.vue'
import Task from '@/Class/Models/Task.js'
import Message from '@/Class/Base/Message.js'
import MdEditor from 'md-editor-v3'

export default {
  name: 'TaskForm',
  components: {
    MdEditor,
    PageHead,
    ContentContainer,
  },

  created() {
    if (this.$route.params.id) {
      this.$taskRepository
        .loadTask(this.$route.params.id)
        .then((task) => {
          this.task = task
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', 'Failed to load task', error))
        })
    }
  },

  data() {
    return {
      task: new Task(),
    }
  },

  methods: {
    onCancel() {
      this.$router.push({ name: 'Task' })
    },

    onSave() {
      // Only set default status for new tasks, preserve existing status for updates
      if (!this.task.id) {
        this.task.status = 'open'
      }

      this.$taskRepository
        .saveTask(this.task)
        .then(() => {
          this.$router.push({ name: 'Task' })
        })
        .catch((error) => {
          this.$mainStore.addStickyMessage(new Message('Error', 'Unable to save Task', error))
        })
    },
  },

  computed: {
    isSaveButtonDisabled() {
      return !this.task.name || !this.task.description || !this.task.priority
    },
  },
}
</script>
<template>
  <page-head title="Create Task">
    <button class="btn btn-primary" :disabled="isSaveButtonDisabled" @click="onSave">
      <i class="bi bi-save"></i>
      Save
    </button>

    <button class="btn btn-secondary" @click="onCancel">
      <i class="bi bi-x-circle"></i>
      Cancel
    </button>
  </page-head>

  <content-container>
    <div class="mb-3">
      <label for="priority" class="form-label">Priority</label>
      <select type="text" class="form-control" name="priority" v-model="task.priority">
        <option value="low">Low</option>
        <option value="mid">Mid</option>
        <option value="high">High</option>
      </select>
    </div>

    <div class="mb-3">
      <label for="name" class="form-label">Name</label>
      <input type="text" class="form-control" name="name" v-model="task.name" />
    </div>

    <div class="mb-3">
      <label for="description" class="form-label">Description</label>
      <md-editor
        theme="dark"
        previewTheme="smart-blue"
        ref="editorRef"
        v-model="task.description"
        language="en-US"
        noUploadImg="true"
      />
    </div>

    <div class="mb-3">
      <label for="date" class="form-label">Due Date</label>
      <input
        type="datetime-local"
        id="due-date"
        class="form-control"
        name="due-date"
        v-model="task.dueDate"
      />
    </div>
  </content-container>
</template>

<style scoped></style>
