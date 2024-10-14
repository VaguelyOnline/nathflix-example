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
    <h3>
        {{ genre.name }}
    </h3>
    <p>
        {{ genre.description }}
    </p>
    <img :src="genre.image_url" alt="Genre image">

    <Link :href="route('genres.index')">
        View all genres
    </Link>
</template>