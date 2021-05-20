<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Пользователи
            </h2>
        </template>
            <toast :success="$page.props.success"/>
        <div class="flex justify-end mb-5">
           <can permission="users.create">
               <inertia-link
                   class="btn-success"
                   :href="route('users.create')"
               >
                   Добавить
               </inertia-link>
           </can>
        </div>
        <template style="display: block">
            <Table
                :meta="salons"
                class="w-full overflow-y-hidden overflow-x-auto"
            >
                <template #head>
                    <tr>
                        <th>ID</th>
                        <th>Название</th>
                        <th>Email</th>
                        <th>Роль</th>
                        <th class="flex justify-center">Действие</th>
                    </tr>
                </template>
                <template #body>
                    <tr v-for="user in users.data" :key="user.id">
                        <td>{{ user.id }}</td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.roles[0].name }}</td>
                        <td class="flex justify-evenly">
                            <can permission="users.edit">
                                <inertia-link
                                    class="text-yellow-400 hover:text-yellow-700"
                                    :href="route('users.edit',user.id)">
                                    Редактировать
                                </inertia-link>
                            </can>
                         <can permission="users.destroy">
                              <span
                                  @click.prevent="showAlert(user.id)"
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
        users: Object,
        success:String,
    },

    mounted() {
      console.log(this.users.data[0].roles[0].name)
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
                    Inertia.delete(route('users.destroy',id))
                }
            })
        },
    }


}
</script>
