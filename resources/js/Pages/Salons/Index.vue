<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Салоны
            </h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <template style="display: block">
                            <Table
                                :meta="salons"
                            >
                                <template #head>
                                    <tr>
                                        <th>ID</th>
                                        <th>Название</th>
                                        <th>Действие</th>
                                    </tr>
                                </template>
                                <template #body>
                                    <tr v-for="salon in salons.data" :key="salon.id">
                                        <td>{{salon.id}}</td>
                                        <td>{{ salon.name }}</td>
                                        <td>
                                            <a :href="route('salons.show', salon.id)" class="text-indigo-600 hover:text-indigo-900">Посмотреть</a>
                                        </td>
                                    </tr>
                                </template>
                            </Table>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import { InteractsWithQueryBuilder, Tailwind2 } from '@protonemedia/inertiajs-tables-laravel-query-builder';
export default {
    mixins: [InteractsWithQueryBuilder],
    components: {
        BreezeAuthenticatedLayout, Table: Tailwind2.Table
    },

    props: {
        auth: Object,
        errors: Object,
        salons: Object,
    },

    mounted() {
        console.log(this.salons)
    }
}
</script>
