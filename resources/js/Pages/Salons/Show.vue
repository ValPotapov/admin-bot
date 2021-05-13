<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Салон {{salon.name}}
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="container my-12 mx-auto px-4 md:px-12">
                    <div class="flex flex-wrap -mx-1 lg:-mx-4">
                        <div v-for="value in date"
                            class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/5" :key="value.label">
                            <article class="overflow-hidden rounded-lg shadow-lg bg-white" >
                                <header class="flex items-center justify-center leading-tight p-2 md:p-4">
                                    <h1 class="text-lg">
                                        <p class="no-underline hover:underline text-black">
                                            {{value.label}}
                                        </p>
                                    </h1>
                                </header>
                                <footer class="flex items-center  justify-center leading-none p-2 md:p-4">
                                        <p class="ml-2 text-sm">
                                            {{value.percent}}%
                                        </p>
                                </footer>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
export default {
name: "Show",
    components:{
        BreezeAuthenticatedLayout
    },
    props:{
        salon:Object,
        date:Object,
    }
}
</script>

<style scoped>

</style>
