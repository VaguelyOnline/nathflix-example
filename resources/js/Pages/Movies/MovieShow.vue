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

    <Link 
        v-for="genre in movie.genres"
        :href="route('genres.show', genre)"  class="badge badge-accent">
        {{ genre.name }}
    </Link>

    <img :src="movie.poster_url">

    <div class="rating gap-1">
        <input type="radio" name="rating-3" class="mask mask-heart bg-orange-400" checked="checked" />
        <input type="radio" name="rating-3" class="mask mask-heart bg-orange-400" checked="checked" />
        <input type="radio" name="rating-3" class="mask mask-heart bg-orange-400" checked="checked" />
    </div>

    <Link :href="route('movies.index')">
        View all movies
    </Link>
</template>