import { defineStore } from 'pinia'
import axios from 'axios'

export const useTaskStore = defineStore('taskStore', {
  state: () => ({
    tasks: [],
    columns: {
      pending: [],
      'in-progress': [],
      completed: [],
      'on-hold': [],
    },
    modalOpen: false,
  }),
  actions: {
    async fetchTasks() {
      try {
        const response = await axios.get('/api/tasks')
        this.tasks = response.data.data

        this.columns = {
          pending: [],
          'in-progress': [],
          completed: [],
          'on-hold': [],
        }

        for (const task of this.tasks) {
          switch (task.status.id) {
            case 1:
              this.columns.pending.push(task)
              break
            case 2:
              this.columns['in-progress'].push(task)
              break
            case 3:
              this.columns.completed.push(task)
              break
            case 4:
              this.columns['on-hold'].push(task)
              break
          }
        }
      } catch (error) {
        console.error('Failed to fetch tasks:', error)
      }
    },
    async updateTaskStatus(taskId, newStatusId) {
      try {
        await axios.put(`/api/tasks/${taskId}`, {
          status_id: newStatusId,
        })
        
        await this.fetchTasks()
      } catch (error) {
        console.error('Failed to update task status:', error)
      }
    },
    async addTask(data) {
      try {
        await axios.post('/api/tasks', data)

        await this.fetchTasks()
      } catch (error) {
        console.error('Failed to add task:', error)
      }
    },
    async deleteTask(taskId) {
      try {
        await axios.delete(`/api/tasks/${taskId}`)

        await this.fetchTasks()
      } catch (error) {
        console.error('Failed to delete task:', error)
      }
    },
  },
})
