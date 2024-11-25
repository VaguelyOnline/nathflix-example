<template>
    <div v-if="car">
      <div 
        class="car-display" 
        :style="{ backgroundImage: `url(${car.image_url})` }">
      </div>
      <p>Make: {{ car.make }}</p>
      <p>Model: {{ car.model }}</p>
      <p>Price: {{ car.price }}</p>
    </div>
  </template>
  
  <script setup>
  import { defineProps } from 'vue';
  
  const props = defineProps({
    car: {
      type: Object,
      required: true
    }
  });
  </script>
  
  <style scoped>
  .car-display {
    width: 400px;
    height: 250px;
    background-size: cover;
    background-position: center;
    border: 2px solid #333;
    margin: 20px auto;
  }
  </style>
  