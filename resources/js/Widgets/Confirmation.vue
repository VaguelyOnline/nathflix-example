<script setup>

    import { ref, defineExpose } from 'vue';

    defineProps({
        title: {
            required: true,
            type: String
        },

        text: {
            required: true,
            type: String
        },

        buttons: {
            required: false,
            type: Array,
        }
    });

    const modal = ref(null);

    function show() {
        modal.value.showModal();
    }

    defineExpose({
        show
    });

</script>

<template>
    <dialog ref="modal" class="modal">
        <div class="modal-box">
            <h3 class="text-lg font-bold">{{ title }}</h3>
            <p class="py-4">{{ text }}</p>
            <div class="modal-action">
            <form method="dialog">
                <slot name="buttons">
                    <button class="btn">Close</button>
                </slot>
            </form>
            </div>
        </div>
    </dialog>
</template>