<script setup>

import { router, Link } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const { genresData } = defineProps({
    genresData: {
        required: true,
        type: Object
    }
});

const genres = genresData.data;
const links = genresData.links;

function showGenre(genre) {
    // Manually visit the page for the genre...
    router.visit(route('genres.show', genre));
}

</script>

<template>
    <h1>Browse our great selection of movie genres!</h1>

    <Link class="btn"  
        v-for="link in links" :href="link.url">
        <span v-html="link.label" />
    </Link>

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