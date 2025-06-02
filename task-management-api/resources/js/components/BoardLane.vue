<template>
  <div class="droppable-column" :data-status-key="id">
    <slot></slot>
  </div>
</template>

<script setup>
defineProps({
  id: String,
})
</script>

<style scoped>
.droppable-column {
  min-height: 200px;
  padding: 8px;
  background-color: #f3f4f6;
  border-radius: 8px;
  box-sizing: border-box;
}
</style>
