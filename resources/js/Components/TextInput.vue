<script setup>
import { onMounted, ref } from 'vue';

defineProps({
    modelValue: String,
});

defineEmits(['update:modelValue']);

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <input ref="input"
        class="border-stone-300 dark:border-stone-700 dark:bg-stone-900 dark:text-stone-300 focus:border-blue-500 dark:focus:border-blue-800 focus:ring-blue-500 dark:focus:ring-blue-800 rounded-md shadow-sm"
        :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
</template>
