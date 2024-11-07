<script setup>
import { ref, onMounted } from 'vue';

const isDarkMode = ref(false);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    document.getElementById(isDarkMode.value ? 'moon-fill' : 'sun-fill').classList.add('hidden');
    document.getElementById(isDarkMode.value ? 'moon' : 'sun').classList.add('hidden');
    document.getElementById(isDarkMode.value ? 'sun-fill' : 'moon-fill').classList.remove('hidden');
    localStorage.theme = isDarkMode.value ? 'dark' : 'light';
};

const fillIcon = () => {
    document.getElementById(isDarkMode.value ? 'sun' : 'moon').classList.add('hidden');
    document.getElementById(isDarkMode.value ? 'sun-fill' : 'moon-fill').classList.remove('hidden');
};

const outlineIcon = () => {
    document.getElementById(isDarkMode.value ? 'sun-fill' : 'moon-fill').classList.add('hidden');
    document.getElementById(isDarkMode.value ? 'sun' : 'moon').classList.remove('hidden');
};

onMounted(() => {
    isDarkMode.value = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    document.getElementById(isDarkMode.value ? 'sun' : 'moon').classList.remove('hidden');
});
</script>
<template>
    <div v-auto-animate>
        <transition enter-active-class="transition ease-out duration-200"
            enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
            leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
            leave-to-class="transform opacity-0 scale-95">
            <button
                class="border-2 border-blue-950 dark:border-stone-50 text-stone-950 dark:text-stone-50 rounded-full h-12 w-12 flex items-center justify-center"
                @click="toggleDarkMode" @mouseenter="fillIcon" @mouseleave="outlineIcon">

                <iconify-icon id="sun" icon="meteocons:clear-day" mode="svg" width="32" height="32"
                    class="hidden"></iconify-icon>
                <iconify-icon id="sun-fill" icon="meteocons:clear-day-fill" mode="svg" width="32" height="32"
                    class="hidden"></iconify-icon>
                <iconify-icon id="moon" icon="meteocons:clear-night" mode="svg" width="32" height="32"
                    class="hidden"></iconify-icon>
                <iconify-icon id="moon-fill" icon="meteocons:clear-night-fill" mode="svg" width="32" height="32"
                    class="hidden"></iconify-icon>

            </button>
        </transition>
    </div>
</template>
