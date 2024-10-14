<script setup>
import MovieDetails from '@/Movie/MovieDetails.vue';
import { Head, Link } from '@inertiajs/vue3';
import { ref, computed, defineProps } from 'vue';

const newMovie = ref({
    name: '',
    year: 0
});

</script>

<template>

    <MovieDetails v-model="newMovie" />

    <h1>
        The new movie is: {{ newMovie.name }} 
        and was released in {{ newMovie.year }}
    </h1>

    <Link href="/parasite">Click to view movie info</Link>

</template>


