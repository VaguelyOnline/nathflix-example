<script setup>

import { Link, router } from '@inertiajs/vue3';

defineProps({
    movie: {
        required: true,
        type: Object
    }
});

</script>

<template>
    <h1>
        {{ movie.name }}
    </h1>

    <img :src="movie.poster_url">

    <Link :href="route('movies.index')">
        View all movies
    </Link>
</template>