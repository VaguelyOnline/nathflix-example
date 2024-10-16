<script setup>

import { Link } from '@inertiajs/vue3';

const { movie } = defineProps({
    movie: {
        required: true,
        type: Object
    }
});

const style = {
    'background-image': 'url(' + movie.poster_url + ')'
};

</script>

<template>
    <div :style="style" class="bg-cover">
        <div class="
            h-[80vh] 
            pt-32 
            px-12 
            bg-gradient-to-r 
            from-black
            via-black/80 to-transparent">
            <h1 class="text-7xl text-white font-extrabold mb-2">
                {{ movie.name }}
            </h1>
            <h2 class="text-slate-300 text-2xl mb-2">
                #1 Recommendation for today
            </h2>
            <p class="text-slate-300 mb-8 line-clamp-3 w-3/5">
                {{ movie.description }}
            </p>
            <Link :href="route('movies.show', movie.id)" class="btn btn-primary btn-lg w-40 me-10">
                Play
            </Link>

            <Link :href="route('movies.show', movie.id)" class="w-40 btn-lg btn btn-secondary">
                More info
            </Link>
        </div>
    </div>
</template>