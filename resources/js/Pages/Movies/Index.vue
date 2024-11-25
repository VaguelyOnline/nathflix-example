<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, watch, defineEmits } from 'vue';
import { debounce } from 'underscore';
import FeaturedMovie from '@/Movie/FeaturedMovie.vue';
import MovieList from '@/Movie/MovieList.vue';
import Paginator from '@/Widgets/Paginator.vue';

const emit = defineEmits({
//
})

const props = defineProps({
    paginator: {
        required: true,
        type: Object,
    },
    searchInput: {
        required: false,
        type: String,
        default: "",
    },
    featuredMovie: {
        required: false,
        type: Object
    },
    genres: {
        required: true,
        type: Object
    }
});

// Define search input and selected genre as reactive refs
let { searchInput, featuredMovie, genres } = props;
const search = ref(searchInput);
const selectedGenre = ref('');  // This will store the selected genre

// Movie search logic
function movieMatchesSearch(movie, str) {
    return movie.name.toLowerCase().includes(str.toLowerCase());  // Case-insensitive search
}

// Method to trigger search
function doSearch() {
    router.reload({
        data: {
            search: search.value,
            genre: selectedGenre.value,  // Include genre in the search parameters
            page: 1  // Reset to page 1 when a new search is made
        },
        only: ['paginator'],  // Only reload the paginator
    });
}

// Debounce the search function to prevent multiple API calls while typing
const searchDebouncer = debounce(doSearch, 800);

// Watch search input and genre to trigger the debounced search
watch([search, selectedGenre], searchDebouncer);  // Watch both search and genre to trigger the search when either changes

</script>

<template>
    <div class="container mx-auto">

        <!-- Featured Movie -->
        <FeaturedMovie v-if="featuredMovie" :movie="featuredMovie" />

        <!-- Search Form -->
        <form class="my-5 flex items-center" @submit.prevent="doSearch">
            <input 
                type="text" 
                v-model="search" 
                placeholder="Search for your favourite movie"
                class="input input-bordered w-full max-w-xs mr-5">
            <button class="btn btn-secondary">Search</button>
            <button
                class="btn btn-success"
                @click.prevent="generateRandomMovie"
            >
                Generate Random Movie
            </button>
        </form>

        <!-- Genre Selection Dropdown -->
        <select v-model="selectedGenre" @change="doSearch" class="select select-bordered">
            <option value="">Select Genre</option>
            <option v-for="genre in genres" :key="genre" :value="genre">{{ genre }}</option>
        </select>

        <!-- Paginator Component -->
        <Paginator class="mb-5" :links="props.paginator.links" />

        <!-- Movie List Component -->
        <MovieList :movies="props.paginator.data" />
    </div>
</template>
