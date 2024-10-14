<script setup>

import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Link } from '@inertiajs/vue3';
const props = defineProps({
    paginator: {
        required: true,
        type: Object
    }
});

const { paginator } = props;
const { links, data } = paginator;

</script>

<template>

    <GuestLayout>

        <div v-for="movie in data">
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