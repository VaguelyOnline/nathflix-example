<template>
  <div class="container mx-auto">
    <div class="carousel w-full">
      <div v-for="(car, index) in cars" :id="'slide' + index" class="carousel-item relative w-full">
        <img :src="car.image_url" class="w-full" />
        <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
          <a :href="getPreviousCarHref(index)" class="btn btn-circle">❮</a>
          <a ref="nextButton" :href="getNextCarHref(index)" class="btn btn-circle">❯</a>
        </div>
      </div>
    </div>
    <h1>The Vintage Dealer</h1>
    <h3>#1 in the UK for Vintage car sales and detailing</h3>

    <!-- Display the currently selected car -->
    <CarDisplay :car="currentCar" />

    <!-- Display buttons for each car in the list -->
    <div class="car-buttons">
      <CarButton v-for="car in cars" :key="car.id" :car="car" @selectCar="selectCar" />
    </div>
  </div>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, useTemplateRef } from 'vue';
import CarDisplay from './CarDisplay.vue';
import CarButton from './CarButton.vue';

// Accept cars data as a prop
const props = defineProps({
  cars: Array
});

const nextButton = useTemplateRef('nextButton');

const currentCar = ref(props.cars[0]); // Initialize the first car from the passed data
let index = 0;
let carouselInterval = null;

// Start carousel based on the passed cars data
function startCarousel() {
  carouselInterval = setInterval(() => {
    index = (index + 1) % props.cars.length;
    currentCar.value = props.cars[index];

    // inc the carousel
    nextButton.value[index].click();
  }, 2000);
}

// Stop the carousel when a car is manually selected
function stopCarousel() {
  if (carouselInterval) {
    clearInterval(carouselInterval);
    carouselInterval = null;
  }
}

function getPreviousCarHref(index) {

  if (index === 0)
    index = props.cars.length;

  return '#slide' + (index - 1);
}

function getNextCarHref(index) {

if (index === props.cars.length-1)
  index = -1;

  return '#slide' + (index + 1);
}

// Select a car and stop the carousel
function selectCar(car) {
  stopCarousel();
  currentCar.value = car;
}

onMounted(startCarousel);
onBeforeUnmount(stopCarousel);

</script>

<style scoped>
.car-buttons {
  display: flex;
  justify-content: space-around;
  margin-top: 20px;
}
</style>
