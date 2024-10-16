<script setup>

import { Link } from '@inertiajs/vue3';

defineProps({
    links: {
        required: true,
        type: Array
    }
});

</script>

<template>

    <div class="join">
        <Link 
            :href="link.url || 'null'"
            :preserve-scroll="true"
            v-for="link in links" 
            :key="link.label"
            class="join-item btn"
            :class="{'btn-active': link.active}" 
            v-html="link.label" />
    </div>

</template>
