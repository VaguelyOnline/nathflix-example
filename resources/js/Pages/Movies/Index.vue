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
    <div class="navbar bg-base-100">
        <div class="navbar-start">
            <div class="dropdown">
                <div tabindex="0" role="button" class="btn btn-ghost btn-circle">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7" />
                    </svg>
                </div>
                <ul tabindex="0"
                    class="menu menu-sm dropdown-content bg-base-100 rounded-box z-[1] mt-3 w-52 p-2 shadow">
                    <li><a>Movies</a></li>
                    <li><a>Genres</a></li>
                </ul>
            </div>
        </div>
        <div class="navbar-center">
            <a class="btn btn-ghost text-xl">NATHFLIX</a>
        </div>
        <div class="navbar-end">
            <button class="btn btn-ghost btn-circle">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>
            <button class="btn btn-ghost btn-circle">
                <div class="indicator">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span class="badge badge-xs badge-primary indicator-item"></span>
                </div>
            </button>
        </div>
    </div>

    <div class="container mx-auto">

        <FeaturedMovie v-if="featuredMovie" :movie="featuredMovie" />

        <form class="my-5 flex items-center" @submit.prevent="doSearch">
            <input type="text" v-model="search" placeholder="Search for your favourite movie"
                class="input input-bordered w-full max-w-xs mr-5">

            <button class="btn btn-secondary">Search</button>
        </form>

        <Paginator class="mb-5" :links="props.paginator.links" />

        <MovieList :movies="props.paginator.data" />

    </div>

</template>