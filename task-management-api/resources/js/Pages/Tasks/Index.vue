<template>
  <div class="board-container">
    <button class="floating-btn" @click="openModal">+</button>

    <div
      v-for="status in statuses"
      :key="status.key"
      class="board-column"
    >
      <h2 class="board-title">
        {{ status.key.replace("-", " ") }}
      </h2>

      <BoardLane :id="status.key" class="board-lane">
        <draggable
          v-model="taskStore.columns[status.key]"
          :group="'tasks'"
          @change="(evt) => onDragChange(evt, status.key)"
          item-key="id"
          class="task-list"
        >
          <template #item="{ element }">
            <TaskItem
              :element="element"
              class="task-card"
            />
          </template>
        </draggable>
      </BoardLane>
    </div>

    <CreateTask
      :show="isModalOpen"
      @close="closeModal"
      @submit="handleSubmit"
    />
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useTaskStore } from "../../stores/task.store";
import draggable from "vuedraggable";
import TaskItem from "../../components/TaskItem.vue";
import BoardLane from "../../components/BoardLane.vue";
import CreateTask from "../../components/CreateTask.vue";

const taskStore = useTaskStore();

const statuses = [
  { key: "pending", id: 1 },
  { key: "in-progress", id: 2 },
  { key: "completed", id: 3 },
  { key: "on-hold", id: 4 },
];

onMounted(() => {
  taskStore.fetchTasks();
});

const statusMap = {
  pending: 1,
  "in-progress": 2,
  completed: 3,
  "on-hold": 4,
};

function onDragChange(evt, newStatusKey) {
  let movedTask = null;

  if (evt.moved) {
    movedTask = evt.moved.element;
  } else if (evt.added) {
    movedTask = evt.added.element;
  }

  if (!movedTask) {
    return;
  }

  const newStatusId = statusMap[newStatusKey];
  taskStore.updateTaskStatus(movedTask.id, newStatusId);
}

const openModal = () => {
  taskStore.modalOpen = true;
};

const isModalOpen = ref(taskStore.modalOpen);

function handleSubmit(newTask) {
  taskStore.addTask(newTask);
}
</script>

<style scoped>
* {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.floating-btn {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 50%;
  width: 56px;
  height: 56px;
  font-size: 24px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.2);
  cursor: pointer;
}

.board-container {
  display: flex;
  gap: 16px;
  padding: 16px;
  overflow-x: auto;
  background: linear-gradient(to bottom, #f0f4f8, #ffffff);
  min-height: 100vh;
  flex-wrap: wrap;
  justify-content: center;
}

.board-column {
  flex: 0 0 280px;
  background: #fff;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.board-title {
  font-size: 1rem;
  font-weight: 600;
  text-transform: capitalize;
  background: #f7f7f7;
  padding: 12px;
  border-bottom: 1px solid #e0e0e0;
  color: #333;
}

.board-lane {
  flex: 1;
  padding: 8px;
  overflow-y: auto;
}

.task-list {
  display: flex;
  flex-direction: column;
  gap: 8px;
  min-height: 80px;
}

.task-card {
  background: #ffffff;
  border: 1px solid #dcdcdc;
  border-radius: 4px;
  padding: 8px;
  box-shadow: 0 1px 2px rgba(0,0,0,0.05);
  transition: box-shadow 0.2s;
}

.task-card:hover {
  box-shadow: 0 2px 6px rgba(0,0,0,0.1);
  cursor: pointer;
}

.board-container::-webkit-scrollbar {
  height: 6px;
}

.board-container::-webkit-scrollbar-thumb {
  background: rgba(0, 0, 0, 0.2);
  border-radius: 3px;
}
</style>
