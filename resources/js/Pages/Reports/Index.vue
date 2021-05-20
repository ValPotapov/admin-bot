<template>
    <breeze-authenticated-layout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Отчеты
                </h2>
        </template>
            <toast :success="$page.props.success"/>
        <div class="flex justify-end mb-5">
            <can permission="reports.create">
                <inertia-link
                    class="btn-success"
                    :href="route('reports.create')"
                >
                    Добавить
                </inertia-link>
            </can>
        </div>
        <template style="display: block">
            <Table
                :meta="reports"
                class="w-full overflow-y-hidden overflow-x-auto block"
            >
                <template #head>
                    <tr>
                        <th>ID</th>
                        <th>Салон</th>
                        <th>Сумма</th>
                        <th>Дата</th>
                        <th>Кол-во звонков</th>
                        <th>Пришли</th>
                        <th>Остались</th>
                        <th class="flex justify-center">Действие</th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="report in reports.data" :key="report.id">
                        <td>{{ report.id }}</td>
                        <td>{{ report.salon.name }}</td>
                        <td>{{ report.sum }}</td>
                        <td>{{ report.date }}</td>
                        <td>{{ report.number_calls }}</td>
                        <td>{{ report.came }}</td>
                        <td>{{ report.stayed }}</td>
                        <td class="flex justify-evenly">
                            <can permission="reports.edit">
                                <inertia-link
                                    class="text-yellow-400 hover:text-yellow-700"
                                    :href="route('reports.edit',report.id)">
                                    Редактировать
                                </inertia-link>
                            </can>
                           <can permission="reports.destroy">
                               <span
                                   @click.prevent="showAlert(report.id)"
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
        reports: Object,
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
                    Inertia.delete(route('reports.destroy',id))
                }
            })
        },
    }


}
</script>
