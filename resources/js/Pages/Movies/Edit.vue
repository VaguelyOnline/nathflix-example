<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const { movie } = defineProps({
    movie: {
        required: true,
        type: Object
    }
});

const movieForm = useForm({ ... movie });

function submit() {
    movieForm.put(route('movies.update', movie), {
        preserveScroll: true,
    });
}

</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 flex justify-between items-center">
                Editing: {{ movie.name }}
                <Link 
                    class="btn btn-outline btn-secondary btn-sm"
                    :href="route('movies.show', movie)">
                        Switch to normal view
                </Link>
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <form @submit.prevent="submit" class="md:max-w-lg">

                            <label class="form-control w-full mb-8">
                                <div class="label">
                                    <span class="label-text">Movie name</span>
                                </div>
                                <input 
                                    :disabled="movieForm.processing"
                                    v-model="movieForm.name"
                                    type="text" 
                                    placeholder="E.g., The Matrix" 
                                    class="input input-bordered w-full" />
                            </label>

                            <label class="form-control mb-8">
                                <div class="label">
                                    <span class="label-text">Description</span>
                                </div>
                                <textarea
                                    :disabled="movieForm.processing" 
                                    v-model="movieForm.description"
                                    rows="5"
                                    class="textarea textarea-bordered"
                                    placeholder="Tell us what the movie is about"></textarea>
                            </label>
                                
                            <label class="form-control mb-8">
                                <div class="label">
                                    <span class="label-text">Main poster</span>
                                </div>

                                <input 
                                    :disabled="movieForm.processing"
                                    v-model="movieForm.poster_url"
                                    type="text"
                                    placeholder="https://example.com/image.jpg" 
                                    class="input input-bordered w-full mb-4" />
                                
                                <img v-if="movieForm.poster_url" class="rounded-lg" :src="movieForm.poster_url">
                            </label>

                            <Link class="btn btn-outline mr-4" :href="route('movies.show', movie)">
                                Cancel
                            </Link>

                            <button 
                                :disabled="movieForm.processing || !movieForm.isDirty"
                                type="submit" 
                                class="btn btn-primary">
                                    <span v-if="movieForm.processing" class="loading loading-spinner loading-md"></span>
                                    {{ movieForm.processing ? 'Saving' : 'Save' }}
                            </button>

                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>