<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { debounce } from 'underscore';
import FeaturedMovie from '@/Movie/FeaturedMovie.vue';
import MovieList from '@/Movie/MovieList.vue';
import Paginator from '@/Widgets/Paginator.vue';

const props = defineProps({
    paginator: {
        required: true,
        type: Object
    },
    searchInput: {
        required: false,
        type: String,
        default: ''
    },
    featuredMovie: {
        required: false,
        type: Object
    }
});

let { searchInput, featuredMovie } = props;
// const paginator = ref(props.paginator);
const search = ref(searchInput);

function movieMatchesSearch(movie, str) {
    return movie.name.indexOf(str) !== -1
}

function doSearch() {
    router.reload({
        data: {
            search: search.value,
            page: 1
        },
        only: [
            'paginator',
        ]
    });
}

// Create a function that will trigger doSearch when it hasn't been invoked for 800ms
const searchDebouncer = debounce(doSearch, 800);

// When the search ref changes - call the debouncer that will trigger the search
watch(search, searchDebouncer);

</script>

<template>

    <div class="container mx-auto">

        <FeaturedMovie v-if="featuredMovie" :movie="featuredMovie" />
        
        <form class="my-5 flex items-center" @submit.prevent="doSearch">
            <input 
                type="text" 
                v-model="search"
                placeholder="Search for your favourite movie" 
                class="input input-bordered w-full max-w-xs mr-5">

            <button class="btn btn-secondary">Search</button>
        </form>

        <Paginator class="mb-5" :links="props.paginator.links" />

        <MovieList :movies="props.paginator.data" />

    </div>

</template>