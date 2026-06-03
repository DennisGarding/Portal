<script>
import TaskStatusList from '@/components/Task/TaskStatusList.vue'

export default {
  name: 'TaskList',
  components: {
    TaskStatusList,
  },
  props: {
    tasks: {
      type: Array,
      default: () => [],
    },
  },

  data() {
    return {
      isDropzoneOpen: false,
    }
  },

  methods: {
    onTaskDropped(data) {
      this.isDropzoneOpen = false

      if (!data) {
        return
      }

      this.$emit('task-dropped', data)
    },

    onTaskDragged() {
      this.isDropzoneOpen = true
    },

    getTasks(status) {
      return this.tasks.filter((task) => {
        return task.status === status
      })
    },
  },
}
</script>

<template>
  <div class="row">
    <task-status-list
      title="Todo"
      status="open"
      :is-dropzone-open="isDropzoneOpen"
      :tasks="getTasks('open')"
      @taskDropped="onTaskDropped"
      @taskDragged="onTaskDragged"
    />

    <task-status-list
      title="In progress"
      status="inProgress"
      :is-dropzone-open="isDropzoneOpen"
      :tasks="getTasks('inProgress')"
      @taskDropped="onTaskDropped"
      @taskDragged="onTaskDragged"
    />

    <task-status-list
      title="Done"
      status="completed"
      :is-dropzone-open="isDropzoneOpen"
      :tasks="getTasks('completed')"
      @taskDropped="onTaskDropped"
      @taskDragged="onTaskDragged"
    />
  </div>
</template>

<style scoped></style>
