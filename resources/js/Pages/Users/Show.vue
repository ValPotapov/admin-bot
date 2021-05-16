<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Салон {{ salon.name }}
            </h2>
            <div class="flex items-center mt-6 space-x-4 overflow-y-auto 2xl:justify-center whitespace-nowrap">
                <sub-menu-link
                    :href="route('salons.show',salon.id) + '?type=months'"
                    :active="type === 'months'"
                >
                    Проценты по месяцам
                </sub-menu-link>
                <sub-menu-link
                    :href="route('salons.show',salon.id) + '?type=days'"
                    :active="type === 'days'"
                >
                    Кол-во звонков по дням
                </sub-menu-link>
            </div>
        </template>
                    <div class="flex flex-wrap -mx-1 lg:-mx-4">
                        <div v-for="value in date"
                             class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/5" :key="value.label">
                            <article class="overflow-hidden rounded-lg shadow-lg bg-white">
                                <header class="flex items-center justify-center leading-tight p-2 md:p-4">
                                    <h1 class="text-lg">
                                        <p class="no-underline hover:underline text-black">
                                            {{ value.label }}
                                        </p>
                                    </h1>
                                </header>
                                <footer class="flex items-center  justify-center leading-none p-2 md:p-4">
                                    <p class="ml-2 text-sm">
                                        {{ value.value }}
                                    </p>
                                </footer>
                            </article>
                        </div>
                    </div>

    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import Dropdown from "@/Components/Dropdown";
import DropdownLink from "@/Components/DropdownLink";
import SubMenuLink from "@/Components/SubMenuLink";


export default {
    name: "Show",
    components: {
        SubMenuLink,
        DropdownLink,
        Dropdown,
        BreezeAuthenticatedLayout
    },
    props: {
        salon: Object,
        date: Object,
        type: String,
    }
}
</script>

<style scoped>

</style>
