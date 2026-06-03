<script>
import TaskItem from '@/components/Task/TaskItem.vue'

export default {
  name: 'TaskStatusList',
  components: {
    TaskItem,
  },

  props: {
    title: {
      type: String,
      required: true,
    },

    status: {
      type: String,
      required: true,
    },

    isDropzoneOpen: {
      type: Boolean,
      default: () => false,
      required: true,
    },

    tasks: {
      type: Array,
      default: () => [],
    },
  },

  methods: {
    onDrop(event) {
      event.preventDefault()
      event.stopPropagation()

      const taskId = Number(event.dataTransfer.getData('taskId'))
      const sourceStatus = event.dataTransfer.getData('sourceStatus')

      if (sourceStatus === this.status) {
        this.$emit('task-dropped', null)
      }

      this.$emit('task-dropped', {
        taskId: taskId,
        targetStatus: this.status,
        sourceStatus: sourceStatus,
      })
    },

    onDragOver(event) {
      event.preventDefault()
      event.stopPropagation()
    },

    onDragEnd(event) {
      event.preventDefault()
      event.stopPropagation()
    },

    onTaskDragged(task) {
      this.$emit('task-dragged', task)
    },
  },
}
</script>

<template>
  <div
    class="col status-column col-header"

    @dragover.prevent
    @dragenter="onDragOver"
    @dragend="onDragEnd"
  >
    <div class="card status-column-card">
      <div class="card-header text-center">
        <h4>{{ title }}</h4>
      </div>
      <div class="card-body pt-0" :class="this.isDropzoneOpen ? 'dropzone-open' : null">
        <div class="list">
          <div class="dropzone dropzone-before" @drop="onDrop($event)" :class="dragOverClass" @dragover="onDragOver" @dragleave="onDragLeave"></div>
          <template v-for="task in tasks" :key="task.id">
            <task-item :task="task" @taskDragged="onTaskDragged" />
            <div class="dropzone dropzone-before" @drop="onDrop($event)" :class="dragOverClass" @dragover="onDragOver" @dragleave="onDragLeave"></div>
          </template>
        </div>
      </div>
    </div>
  </div>
</template>

<style scoped>
.status-column {
  height: auto;

  .status-column-card {
    height: 100%;
  }
}

.dropzone-open {
  opacity: .5
}

.dropzone {
  width: 100%;
  height: 20px;

  &.open {
    height: 30px;
    background: #ffffff;
    border: 1px dashed #fff;
    opacity: .5;
    margin-top: 2px;
    margin-bottom: 2px;
  }
}
</style>
