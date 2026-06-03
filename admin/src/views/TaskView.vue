<script>
import ContentContainer from "@/components/Base/ContentContainer.vue";
import PageHead from "@/components/Base/PageHead.vue";
import Message from "@/Class/Base/Message.js";
import TaskList from "@/components/Task/TaskList.vue";

export default {
  name: 'TaskView',
  components: {
    TaskList,
    PageHead,
    ContentContainer
  },

  created() {
    this.loadTasks()
  },

  data() {
    return {
      tasks: [],
    }
  },

  methods: {
    onTaskDropped(data) {
      this.$taskRepository.moveTask(data.taskId, data.targetStatus).then(() => {
        this.loadTasks()
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', `Failed to move task`, error))
      })
    },

    loadTasks() {
      this.$taskRepository.loadTasks().then((response) => {
        this.tasks = response
      }).catch((error) => {
        this.$mainStore.addStickyMessage(new Message('Error', `Failed to load tasks`, error))
      })
    },

    onAddTask() {
      this.$router.push({ name: 'TaskForm' })
    },

    onClickSettings() {

    },
  }
}
</script>

<template>
  <page-head title="Board">
    <button class="btn btn-primary" @click="onAddTask">
      <i class="bi bi-plus-lg"></i>
      Add Task
    </button>
    <button class="btn btn-light" @click="onClickSettings">
      <i class="bi bi-gear"></i>
      Settings
    </button>
  </page-head>

  <content-container>
    <task-list :tasks="tasks" @taskDropped="onTaskDropped"/>
  </content-container>
</template>

<style scoped>

</style>
