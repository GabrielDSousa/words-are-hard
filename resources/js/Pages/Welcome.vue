<script setup>
import DarkModeToggle from '@/Components/DarkModeToggle.vue';
import WelcomeTitle from '@/Components/WelcomeTitle.vue';
import { Head, Link } from '@inertiajs/vue3';


defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});


</script>

<template>

    <Head title="Words are hard" />
    <div class="
        font-['Fredericka_the_Great'] font-semibold dark:font-normal leading-loose tracking-widest
        min-h-screen p-6 px-4 sm:px-8 md:px-16 lg:px-32
        grid grid-rows-6">

        <DarkModeToggle></DarkModeToggle>

        <main class="row-span-4">
            <WelcomeTitle size="full-title"></WelcomeTitle>

            <div v-if="canLogin" class="w-full mt-8 flex justify-around">
                <Link v-if="$page.props.auth.user" :href="route('dashboard')" class="rounded-md
                    p-3 sm:p-4 md:p-5 lg:p-6
                    text-blue-950 dark:text-white
                    ring-1 ring-transparent transition
                    hover:text-blue-950/70 dark:hover:text-white/80
                    focus:outline-none focus-visible:ring-blue-950 dark:focus-visible:ring-stone-50">
                Games
                </Link>

                <template class="flex justify-around" v-else>
                    <Link :href="route('login')" class="p-3 sm:p-4 md:p-5 lg:p-6
                        border-2 border-blue-950 dark:border-stone-50 rounded-md
                        ring-1 ring-transparent transition
                        hover:text-blue-950/70 dark:hover:text-stone-50/80
                        focus:outline-none focus-visible:ring-blue-950 dark:focus-visible:ring-stone-50">
                    Log in
                    </Link>

                    <Link v-if="canRegister" :href="route('register')" class="p-3 sm:p-4 md:p-5 lg:p-6
                        border-2 border-blue-950 dark:border-stone-50 rounded-md
                        ring-1 ring-transparent transition
                        hover:text-blue-950/70 dark:hover:text-stone-50/80
                        focus:outline-none focus-visible:ring-blue-950 dark:focus-visible:ring-stone-50">
                    Register
                    </Link>
                </template>
            </div>
        </main>
        <footer class="py-2 sm:py-4 md:py-8 lg:py-16 text-center text-sm flex justify-center items-end h-full">
            <p>Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})</p>
        </footer>
    </div>
</template>
