<template>
    <div class="h-screen flex items-center justify-center px-6 font-roboto bg-gray-50">
        <div class="max-w-md w-full space-y-8 bg-white py-16 px-6 border-2 rounded-lg">
            <div>
                <h2 class="text-center text-xl font-bold text-gray-900 md:text-3xl">
                    {{ title }}
                </h2>
            </div>
            <slot></slot>
        </div>
    </div>
</template>

<script setup>

const props = defineProps({
    title :{
        type: String
    }
})

</script>

<style lang="">

</style>
