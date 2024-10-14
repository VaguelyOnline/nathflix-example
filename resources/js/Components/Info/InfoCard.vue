<template>
    <div>
        <header>
            <!-- Header -->
            <slot name="header">
                This is default content
            </slot>
        </header>

        <article>
            <slot />
        </article

        <footer>
            <slot name="footer" />
        </footer>
    </div>
</template>