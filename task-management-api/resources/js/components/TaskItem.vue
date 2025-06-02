<template>
  <div class="task"
    :data-task-id="element.id"
    @mouseenter="handleCtaButtonVisibility(true)"
    @mouseleave="handleCtaButtonVisibility(false)"
  >
    <h3 class="task-title">
      {{ element.title }}
      <button class="delete-task" v-show="showCtaButton" title="Delete task" @click="deleteTask">-</button>
    </h3>
    <p class="task-desc">{{ element.description }}</p>

    <div class="task-meta">
      <span>Status: {{ element.status?.name || 'Unknown' }}</span>
      <span>Due: {{ formatDate(element.due_date) }}</span>
      <span>Priority: {{ element.priority }}</span>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useTaskStore } from '../stores/task.store'

const props = defineProps({
  element: {
    type: Object,
    required: true,
  },
})

const taskStore = useTaskStore()
const showCtaButton = ref(false)

function handleCtaButtonVisibility(state) {
  showCtaButton.value = state
}

function formatDate(dateStr) {
  const date = new Date(dateStr)
  return isNaN(date) ? 'N/A' : date.toLocaleDateString()
}

function deleteTask() {
  taskStore.deleteTask(props.element.id)
    .then(() => {
      console.log(`Task ${props.element.id} deleted successfully`)
    })
    .catch(error => {
      console.error(`Failed to delete task ${props.element.id}:`, error)
    })
}
</script>

<style scoped>
.task {
  user-select: none;
  background-color: white;
  padding: 12px;
  margin-bottom: 8px;
  border-radius: 6px;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
  cursor: move;
}

.task-title {
  font-size: 1.125rem;
  font-weight: 600;
  color: #2d2d2d;
  margin-bottom: 4px;
  display: flex;
  flex-direction: row;
  flex-wrap: nowrap;
  align-items: center;
  gap: 1rem;
}

.task-desc {
  font-size: 0.875rem;
  color: #555;
  margin-bottom: 8px;
}

.task-meta {
  font-size: 0.875rem;
  color: #777;
  display: flex;
  flex-direction: column;
  gap: 2px;
}

.delete-task {
  background: none;
	color: inherit;
	border: none;
	padding: 0;
	font: inherit;
	cursor: pointer;
	outline: inherit;
  background-color: #D40000;
  border-radius: 50%;
  color: white;
  font-size: 14px;
  width: 14px;
  height: 14px;
  display: flex;
  justify-content: center;
  align-items: center;
  font-weight: 300;
}
</style>
