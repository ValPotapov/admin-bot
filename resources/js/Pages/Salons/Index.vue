<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Салоны
            </h2>
        </template>
            <toast :success="$page.props.success"/>
        <div class="flex justify-end mb-5">
            <can permission="salons.create">
                <inertia-link
                    class="btn-success"
                    :href="route('salons.create')"
                >
                    Добавить
                </inertia-link>
            </can>
        </div>
        <template style="display: block">
            <Table
                :meta="salons"
                class="w-full overflow-y-hidden overflow-x-auto block"
            >
                <template #head>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Телефон</th>
                        <th>Процент звонков</th>
                        <th>Статистика</th>
                        <th class="flex justify-center">Действие</th>


                    </tr>
                </template>
                <template #body>
                    <tr v-for="salon in salons.data" :key="salon.id">
                        <td>{{ salon.id }}</td>
                        <td>{{ salon.name }}</td>
                        <td>{{ salon.phone }}</td>
                        <td>{{ salon.percent }}</td>
                        <td>
                            <inertia-link
                                class="text-indigo-600 hover:text-indigo-900"
                                :href="route('salons.show',salon.id) + '?type=days'">
                                Посмотреть
                            </inertia-link>
                        </td>
                        <td class="flex justify-evenly">
                            <can permission="salons.edit">
                                <inertia-link
                                    class="text-yellow-400 hover:text-yellow-700"
                                    :href="route('salons.edit',salon.id)">
                                    Редактировать
                                </inertia-link>
                            </can>
                            <can permission="salons.destroy">
                                  <span
                                      @click.prevent="showAlert(salon.id)"
                                      class="text-red-500 hover:text-red-800 cursor-pointer">
                                Удалить
                            </span>
                            </can>
                        </td>
                    </tr>
                </template>
            </Table>
        </template>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
import {InteractsWithQueryBuilder, Tailwind2} from '@protonemedia/inertiajs-tables-laravel-query-builder';
import toast from "@/Components/toast";
import { Inertia } from '@inertiajs/inertia'
import Can from "@/Components/Can";


export default {
    mixins: [InteractsWithQueryBuilder],
    components: {
        Can,
        BreezeAuthenticatedLayout, Table: Tailwind2.Table, toast
    },

    props: {
        auth: Object,
        errors: Object,
        salons: Object,
        success:String,
    },

    mounted() {
      console.log(this.success)
    },
    methods:{
        showAlert(id) {
            // Use sweetalert2
            this.$swal.fire({
                title: 'Вы точно хотите удалить?',
                showDenyButton: true,
                confirmButtonText: `Да`,
                denyButtonText: `Нет`,
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    Inertia.delete(route('salons.destroy',id))
                }
            })
        },
    }


}
</script>
