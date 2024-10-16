<script setup>
import MovieDetails from './MovieDetails.vue';


defineProps({
    movies: {
        required: true,
        type: Array
    }
});

</script>

<template>

    <div class="container">
        <div class="grid md:grid-cols-3 lg:grid-cols-6 gap-3">
            <MovieDetails v-for="movie in movies" :key="movie.id" :movie="movie" />
        </div>
    </div>

</template>