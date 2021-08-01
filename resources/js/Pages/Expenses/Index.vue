<template>
    <breeze-authenticated-layout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Расходы
                </h2>
        </template>
            <toast :success="$page.props.success"/>
        <div class="flex justify-end mb-5">
            <can permission="expenses.create">
                <inertia-link
                    class="btn-success"
                    :href="route('expenses.create')"
                >
                    Добавить
                </inertia-link>
            </can>
        </div>
        <template style="display: block">
            <Table
                :meta="expenses"
                class="w-full overflow-y-hidden overflow-x-auto block"
            >
                <template #head>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Тип расхода</th>
                        <th>Контрагент</th>
                        <th>Сумма</th>
                        <th>Комментарий</th>
                        <th class="flex justify-center">Действие</th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="expense in expenses.data" :key="expense.id">
                        <td>{{ expense.id }}</td>
                        <td>{{ expense.date }}</td>
                        <td>{{ expense.type.name }}</td>
                        <td>{{ expense.contractor.name }}</td>
                        <td class="text-right">{{ expense.sum }}</td>
                        <td>{{ expense.comment }}</td>
                        <td class="flex justify-evenly">
                            <can permission="expenses.edit">
                                <inertia-link
                                    class="text-yellow-400 hover:text-yellow-700"
                                    :href="route('expenses.edit',expense.id)">
                                    Редактировать
                                </inertia-link>
                            </can>
                           <can permission="expenses.destroy">
                               <span
                                   @click.prevent="showAlert(expense.id)"
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
        expenses: Object,
        success:String,
    },

    mounted() {
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
                    Inertia.delete(route('expenses.destroy',id))
                }
            })
        },
    }


}
</script>
