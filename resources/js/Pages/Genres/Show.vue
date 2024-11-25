<script setup>

import { Link } from '@inertiajs/vue3';

defineProps({
    genre: {
        required: true,
        type: Object
    }
});

</script>

<template>
    <div class="sm:container sm:mx-auto px-4">
        <h3>
            Genre: 
            {{ genre.name }}

            <span class="badge badge-info text-white">
                {{ genre.movies_count }} movies
            </span>
        </h3> 
        <p>
            {{ genre.description }}
        </p>
        <img :src="genre.image_url" alt="Genre image" class="w-1/3">

        <h4 class="font-black">Top movies in this Genre</h4>

        <Link class="button" :href="route('movies.show', movie.id)" v-for="movie in genre.movies">
            <p>{{ movie.name }}</p>
        </Link>

        <Link class="btn btn-primary text-white uppercase text-sm" :href="route('genres.index')">
            View all genres
        </Link>
        
    </div>
    
</template>