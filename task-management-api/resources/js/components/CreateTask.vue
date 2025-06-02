<template>
  <div v-if="modalOpen" class="modal-backdrop" @click.self="close">
    <div class="modal-content" role="dialog" aria-modal="true" aria-labelledby="modal-title">
      <header class="modal-header">
        <h2 id="modal-title">{{ title }}</h2>
        <button class="close-btn" @click="close" aria-label="Close modal">&times;</button>
      </header>

      <form @submit.prevent="submitForm" class="modal-form">
        <label>
          Title:
          <input type="text" v-model="form.title" required />
        </label>

        <label>
          Description:
          <textarea v-model="form.description" rows="3" />
        </label>

        <label>
          Status:
          <select v-model.number="form.status_id" required>
            <option :value="1">Pending</option>
            <option :value="2">In Progress</option>
            <option :value="3">Completed</option>
            <option :value="4">On Hold</option>
          </select>
        </label>

        <label>
          Due Date:
          <input type="date" v-model="form.due_date" />
        </label>

        <label>
          Priority:
          <select v-model="form.priority" required>
            <option value="low">Low</option>
            <option value="medium">Medium</option>
            <option value="high">High</option>
          </select>
        </label>

        <button type="submit" class="submit-btn">Add Task</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, watch, defineProps, ref, onMounted } from 'vue'
import { useTaskStore } from '../stores/task.store'

const props = defineProps({
  title: { type: String, default: 'Add New Task' }
})

const modalOpen = ref(false)

onMounted(() => {
  const taskStore = useTaskStore()
  taskStore.fetchTasks()
})

const taskStore = useTaskStore()

const form = reactive({
  title: '',
  description: '',
  status_id: 1,
  due_date: '',
  priority: 'low',
})

watch(() => taskStore.modalOpen, (newVal) => {
  if (!newVal) {
    form.title = ''
    form.description = ''
    form.status_id = 1
    form.due_date = ''
    form.priority = 'low'
  }

  modalOpen.value = newVal
}, { deep: true, immediate: true })

function close() {
  taskStore.modalOpen = false;
}

async function submitForm() {
  try {
    await taskStore.addTask(form)
    close()
  } catch (error) {
    console.error('Failed to add task:', error)
  }
}
</script>

<style scoped>
.modal-backdrop {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background-color: rgba(0,0,0,0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal-content {
  background: white;
  border-radius: 10px;
  width: 90%;
  max-width: 400px;
  padding: 20px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.25);
  display: flex;
  flex-direction: column;
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 16px;
}

.close-btn {
  background: none;
  border: none;
  font-size: 24px;
  line-height: 1;
  cursor: pointer;
}

.modal-form label {
  display: flex;
  flex-direction: column;
  margin-bottom: 12px;
  font-weight: 600;
  font-size: 14px;
  color: #333;
}

.modal-form input[type="text"],
.modal-form input[type="date"],
.modal-form textarea,
.modal-form select {
  margin-top: 4px;
  padding: 6px 8px;
  font-size: 14px;
  border: 1px solid #ccc;
  border-radius: 6px;
  resize: vertical;
  font-family: inherit;
}

.submit-btn {
  background-color: #007bff;
  color: white;
  font-weight: 600;
  border: none;
  padding: 10px;
  border-radius: 6px;
  cursor: pointer;
  margin-top: 12px;
  transition: background-color 0.2s;
}

.submit-btn:hover {
  background-color: #0056b3;
}
</style>
