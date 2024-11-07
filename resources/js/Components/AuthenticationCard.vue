<script setup lang="ts">
import DarkModeToggle from './DarkModeToggle.vue';
</script>

<template>
    <div class="min-h-screen">
        <DarkModeToggle class="m-4"></DarkModeToggle>

        <div class="flex flex-col sm:justify-center items-center">
            <div>
                <slot name="logo" />
            </div>

            <div
                class="w-full sm:max-w-md mt-6 px-6 py-4 bg-stone-50 dark:bg-stone-800 shadow-md overflow-hidden sm:rounded-lg">
                <slot />
            </div>
        </div>
    </div>
</template>
