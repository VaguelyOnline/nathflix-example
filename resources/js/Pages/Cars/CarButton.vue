<template>
    <button @click="selectCar">{{ car.make }} {{ car.model }}</button>
  </template>
  
  <script setup>
  import { defineProps, defineEmits } from 'vue';
  
  const props = defineProps({
    car: {
      type: Object,
      required: true
    }
  });
  const emit = defineEmits(['selectCar']);
  
  function selectCar() {
    emit('selectCar', props.car);
  }
  </script>
  
  <style scoped>
  button {
    padding: 10px;
    background-color: purple;
    color: white;
    width: 150px;
    border: none;
    cursor: pointer;
    font-size: 16px;
  }
  button:hover {
    background-color: darkpurple;
  }
  </style>
  