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
    <div class="container mx-auto md:w-2/3 pt-4">
        <h1 class="text-xl">
            {{ movie.name }}

            <Link 
                v-for="genre in movie.genres"
                :href="route('genres.show', genre)"  class="badge badge-accent ml-2 text-gray-200">
                {{ genre.name }}
            </Link>
            
            <Link class="btn btn-secondary btn-sm float-right" :href="route('movies.index')">
                View all movies
            </Link>
        </h1>

        <div class="my-4">
            <div class="aspect-w-16 aspect-h-9">
                <iframe :src="route('movies.trailer', movie)" 
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
            </div>
        </div>
    </div>
</template>