<script>
import Task from '@/Class/Models/Task.js'
import { DateFormater } from '@/Services/DateTimeFormatter.js'

export default {
  name: 'TaskItem',

  computed: {
    DateFormater() {
      return DateFormater
    },

    dragOverClass() {
      return this.isDragOver ? 'open' : null
    },
  },

  data() {
    return {
      isDragOver: false,
    }
  },

  props: {
    task: {
      type: Task,
      default: new Task(),
    },
  },

  methods: {
    dragStart(event, task) {
      event.dataTransfer.dropEffect = 'move'
      event.dataTransfer.effectAllowed = 'move'
      event.dataTransfer.setData('taskId', task.id)
      event.dataTransfer.setData('sourceStatus', task.status)

      this.$emit('task-dragged', task)
    },

    getBadgeClass(priority) {
      switch (priority) {
        case 'mid':
          return 'bg-warning'
        case 'high':
          return 'bg-danger'
        default:
          return 'bg-light'
      }
    },

    truncateText(text, length) {
      if (text.length < length) {
        return text
      }

      return `${text.substring(0, length)}...`
    },

    onTaskTitleClick() {
      this.$router.push({ name: 'TaskDetail', params: { id: this.task.id } })
    },

    onDragLeave() {
        window.setTimeout(() => {
          this.isDragOver = false;
        }, 100);
    },

    onDragOver() {
      this.isDragOver = true;
    },

    onDrop() {
      // TODO: REMOVE AFTER DEBUG
      console.log(arguments);
      // TODO: REMOVE AFTER DEBUG

      this.onDragLeave();
    }
  },
}
</script>

<template>
  <div class="toast show w-100" draggable="true" @dragstart="dragStart($event, task)">
    <div class="toast-body">
      <strong class="me-auto task-title" @click="onTaskTitleClick">{{
        truncateText(task.name, 40)
      }}</strong>
      <div class="mt-2">
        <span class="badge rounded-pill" :class="getBadgeClass(task.priority)">{{
          task.priority
        }}</span>
      </div>

      <div class="mt-2">
        <small v-if="task.dueDate">Due on: {{ DateFormater.formate(task.dueDate) }}</small>
      </div>
    </div>
  </div>
</template>

<style scoped>
.task-title {
  cursor: pointer;
}


</style>
