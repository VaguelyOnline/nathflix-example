<script setup>
import { ref } from 'vue';
import { Link, router } from '@inertiajs/vue3';
import Confirmation from '@/Widgets/Confirmation.vue';

const { movie } = defineProps({
    movie: {
        required: true,
        type: Object
    }
});

const loading = ref(true);
function iframeLoaded() {
    loading.value = false;
}

const confirmation = ref(null);
function confirmDelete() {
    // show the modal for the confirming the delete
    confirmation.value.show();
}


function doDelete() {
    router.delete(route('movies.destroy', movie))
}


</script>

<template>

    <Confirmation ref="confirmation" title="Please confirm" text="Are you sure you wish to delele this movie?">
        <template #buttons>
            <button class="btn mr-4">Cancel</button>
            <button @click="doDelete" class="btn btn-warning">Delete</button>
        </template>
    </Confirmation>

    <div class="container mx-auto md:w-2/3 pt-4">
        <h1 class="text-xl flex items-center justify-between text font-extrabold">
            <span>
                {{ movie.name }}

                <Link 
                    v-for="genre in movie.genres"
                    :href="route('genres.show', genre)"  class="badge badge-accent ml-2 text-gray-200">
                    {{ genre.name }}
                </Link>
            </span>
            
            <span>
                <details v-if="$page.props.auth.user" class="dropdown mr-4">
                    <summary class="btn btn-neutral m-1">Manage</summary>
                    <ul class="menu dropdown-content bg-base-100 rounded-box z-[1] w-52 p-2 shadow">
                        <li><Link :href="route('movies.edit', movie.id)">Edit</Link></li>
                        <li><a @click="confirmDelete">Delete</a></li>
                    </ul>
                </details>
                <Link class="btn btn-secondary" :href="route('movies.index')">
                    View all movies
                </Link>
            </span>
            
        </h1>

        <div class="my-4">
            <div class="aspect-w-16 aspect-h-9 mb-4" :class="{hidden: loading}">
                <iframe :src="route('movies.trailer', movie)" 
                    @load="iframeLoaded"
                    frameborder="0" 
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen>
                </iframe>
            </div>

            <div v-if="loading" class="aspect-w-16 aspect-h-9 mb-4">
                <div class="flex justify-center bg-slate-200 rounded-lg">
                    <span class="loading loading-spinner w-20"></span>
                </div>
            </div>

            <p class="text-slate-400">
                {{ movie.description }}
            </p>
        </div>
    </div>
</template>