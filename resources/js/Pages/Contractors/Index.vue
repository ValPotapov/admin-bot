<template>
    <breeze-authenticated-layout>
        <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Типы расходов
                </h2>
        </template>
            <toast :success="$page.props.success"/>
        <div class="flex justify-end mb-5">
            <can permission="contractors.create">
                <inertia-link
                    class="btn-success"
                    :href="route('contractors.create')"
                >
                    Добавить
                </inertia-link>
            </can>
        </div>
        <template style="display: block">
            <Table
                :meta="contractors"
                class="w-full overflow-y-hidden overflow-x-auto block"
            >
                <template #head>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th class="flex justify-center">Действие</th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="contractor in contractors.data" :key="contractor.id">
                        <td>{{ contractor.id }}</td>
                        <td>{{ contractor.name }}</td>
                        <td class="flex justify-evenly">
                            <can permission="contractors.edit">
                                <inertia-link
                                    class="text-yellow-400 hover:text-yellow-700"
                                    :href="route('contractors.edit',contractor.id)">
                                    Редактировать
                                </inertia-link>
                            </can>
                           <can permission="contractors.destroy">
                               <span
                                   @click.prevent="showAlert(contractor.id)"
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
        contractors: Object,
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
                    Inertia.delete(route('contractors.destroy',id))
                }
            })
        },
    }


}
</script>
