<script setup>

import { router } from '@inertiajs/vue3';

const { movie } = defineProps({
    movie: {
        required: true
    }
});

const movieUrl = route('movies.show', movie.id);

const shareMovie = () => {
    const url = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(movieUrl)}&quote=${encodeURIComponent(movie.name)}`;
    window.open(url, 'Share on Facebook', 'width=600,height=400,menubar=no,toolbar=no,location=yes,scrollbars=yes,resizable=yes,status=no');
};

</script>

<template>

    <div @click="router.visit(movieUrl)" class="card bg-base-700 image-full w-full h-30 cursor-pointer">
        <figure>
            <img
                :src="movie.poster_url"
                alt="Image for the movie" />
        </figure>
        <div class="card-body">
            <h2 class="card-title">{{ movie.name }}</h2>
            <p>
                <div v-for="genre in movie.genres" class="badge badge-outline">
                    {{ genre.name }}
                </div>
            </p>
            <div class="card-actions">
                <button class="btn w-full btn-outline-secondary" @click.stop="shareMovie">Share on Facebook</button>
            </div>
        </div>
    </div>

</template>

