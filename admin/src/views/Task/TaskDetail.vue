<script>
import PageHead from '@/components/Base/PageHead.vue'
import Message from '@/Class/Base/Message.js'
import Task from '@/Class/Models/Task.js'
import ContentContainer from '@/components/Base/ContentContainer.vue'
import MdEditor from 'md-editor-v3'
import BaseModal from '@/components/Base/BaseModal.vue'
import TaskStatusBadge from "@/components/Base/TaskStatusBadge.vue";
import {DateFormater} from "@/Services/DateTimeFormatter.js";

export default {
  name: 'TaskDetail',
  computed: {
    DateFormater() {
      return DateFormater
    }
  },
  components: {
    TaskStatusBadge,
    BaseModal,
    MdEditor,
    ContentContainer,
    PageHead,
  },

  created() {
    if (!this.$route.params.id) {
      this.$mainStore.addStickyMessage(new Message('Error', 'Failed to load task. No id provided'))
    }

    this.$taskRepository
      .loadTask(this.$route.params.id)
      .then((response) => {
        this.task = response
      })
      .catch((error) => {
        this.$mainStore.addStickyMessage(
          'error',
          `Could not load task with ID: ${this.task.id}.`,
          error,
        )
      })
  },

  data() {
    return {
      task: new Task(),
      isDeleteConfirmModalOpen: false,
    }
  },

  methods: {
    onEditClick() {
      this.$router.push({ name: 'TaskForm', params: { id: this.task.id } })
    },

    onDeleteClick() {
      this.isDeleteConfirmModalOpen = true;
    },

    onConfirmDelete() {
      this.$taskRepository.deleteTask(this.task.id).then(() => {
        this.$mainStore.addMessage(new Message('Deleted', 'Task successfully deleted'))
        this.$router.push({ name: 'Task'})
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', 'Cannot delete task.', error))
        this.isDeleteConfirmModalOpen = false;
      });
    },

    closeDeleteModal() {
      this.isDeleteConfirmModalOpen = false;
    },
  },
}
</script>

<template>
  <page-head title="Task">
    <button class="btn btn-primary" @click="onEditClick()">
      <i class="bi bi-pencil"></i>
      Edit Task
    </button>
    <button class="btn btn-sm btn-danger" type="button" @click="onDeleteClick()">
      <i class="bi bi-trash"></i>
      Delete Task
    </button>
  </page-head>

  <content-container>
    <h3>{{ task.name }}</h3>
      <div class="mb-3">Status: <task-status-badge :status="task.status"/></div>
      <div class="mb-3" v-if="task.dueDate"> Due on: <small>{{ DateFormater.formate(task.dueDate) }}</small></div>

    <md-editor
      theme="dark"
      previewTheme="smart-blue"
      ref="editorRef"
      v-model="task.description"
      language="en-US"
      previewOnly
    />
  </content-container>

  <base-modal :open="isDeleteConfirmModalOpen" @close="closeDeleteModal">
    <template #title>Delete Task</template>
    <template #content>Are you sure you want to delete this task?</template>
    <template #buttons>
      <button class="btn btn-light" @click="closeDeleteModal">Cancel</button>
      <button class="btn btn-danger" @click="onConfirmDelete">Delete</button>
    </template>
  </base-modal>
</template>

<style scoped></style>
