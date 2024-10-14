<script setup>

    const model = defineModel();

</script>

<template>

    <input type="text" v-model="model.name"> - Name <br>
    <input type="number" v-model="model.year"> - Year released

</template>