<script setup>

import { router } from '@inertiajs/vue3';
import { defineProps } from 'vue';

defineProps({
    genres: {
        required: true,
        type: Array
    }
});

function showGenre(genre) {
    // Manually visit the page for the genre...
    router.visit(route('genres.show', genre));
}

</script>

<template>
    <h1>Browse our great selection of movie genres!</h1>

    <div v-for="genre in genres" class="genre-summary" @click="showGenre(genre)">
        <h3>
            {{ genre.name }}
        </h3>
        <img :src="genre.image_url" alt="Genre image">
    </div>
</template>

<style scoped>
    .genre-summary {
        max-width: 300px;
        cursor: pointer;
    }

    .genre-summary:hover {
        background-color: lightblue;
    }
</style>