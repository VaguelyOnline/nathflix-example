<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';
import { debounce } from 'underscore';

const props = defineProps({
    paginator: {
        required: true,
        type: Object
    },
    searchInput: {
        required: false,
        type: String,
        default: ''
    }
});

const { paginator, searchInput } = props;
const { links, data } = paginator;
const movies = data;
const search = ref(searchInput);

function movieMatchesSearch(movie, str) {
    return movie.name.indexOf(str) !== -1
}

const filteredMovies = computed(() => movies.filter(movie => movieMatchesSearch(movie, search.value)));

function doSearch() {
    router.visit(route('movies.index'), {
        data: {
            search: search.value
        }
    });
}

const searchDebouncer = debounce(doSearch, 800);

watch(search, searchDebouncer);

</script>

<template>

    <GuestLayout>

        
        <input 
            type="text" 
            v-model="search"
            placeholder="Search for your favourite movie" 
            class="input input-bordered w-full max-w-xs">

        <button @click="doSearch" class="btn btn-secondary">Search</button>

        <div v-for="movie in movies">
            <Link :href="route('movies.show', movie.id)">
                {{ movie.name }}
            </Link>
        </div>

        <div>
            <Link :href="link.url || 'null'" v-for="link in links">
                Page <span v-html="link.label" />
            </Link>

        </div>
    </GuestLayout>

</template>