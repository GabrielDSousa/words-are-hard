<script setup>
import { computed } from 'vue';

const props = defineProps({
    phrase: {
        type: String,
        default: "Words Are Hard"
    },
    size: {
        type: String,
        default: "full-title"
    }

})

const letterArray = computed(() => {
    return letterArray.value = props.phrase
        .split(" ")
        .map(word => word.split(""));
})
</script>

<template>
    <div v-auto-animate class="grid grid-rows-3">
        <div v-for="word in letterArray" class="flex flex-row place-self-center" :class="{
            'text-base sm:text-lg md:text-2xl lg:text-4xl': $props.size === 'full-title',
            'text-sm': $props.size === 'logo'
        }">
            <div v-for="letter in word"
                class="border-2 border-blue-950 dark:border-stone-50 rounded-md p-1 sm:p-2 lg:p-4 mx-1 md:mx-2 flex flex-col justify-center items-center"
                :class="{
                    'h-12 w-12 sm:h-16 sm:w-16 md:h-24 md:w-24 lg:h-32 lg:w-32 mb-2': $props.size === 'full-title',
                    'h-10 w-10 mb-0.5': $props.size === 'logo'
                }">
                <p class="text-center align-middle uppercase">
                    {{ letter }}
                </p>
            </div>
        </div>
    </div>
</template>
