<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Редактировать расход
            </h2>
        </template>
        <ValidationErrors/>
        <form class="w-full max-w-lg" @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="date">
                        Дата
                    </label>
                    <input
                        v-model="expenseObj.date"
                        id="date"
                        type="date"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        required
                    />

                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="contractor">
                        Контрагент
                    </label>

                    <Multiselect
                        :searchable="true"
                        v-model="expenseObj.contractor"
                        :options="listContractors"
                        label="name"
                        valueProp="id"
                        trackBy="name"
                        id="contractor"
                    >

                    </Multiselect>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="type">
                        Тип расхода
                    </label>

                    <Multiselect
                        :searchable="true"
                        v-model="expenseObj.type"
                        :options="listTypes"
                        label="name"
                        valueProp="id"
                        trackBy="name"
                        id="type"
                    >

                    </Multiselect>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="sum">
                        Сумма
                    </label>
                    <input
                        v-model="expenseObj.sum"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="sum" type="text" placeholder="Сумма" required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="comment">
                        Комментарий
                    </label>
                    <textarea
                        v-model="expenseObj.comment"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="comment" type="text" placeholder="Комментарий" required>
                    </textarea>
                </div>
            </div>
            <button class="btn-success m-0 mt-5 bg-rose-600">Обновить</button>
        </form>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import SubMenuLink from "@/Components/SubMenuLink";
import ValidationErrors from "@/Components/ValidationErrors";
import Multiselect from '@vueform/multiselect'


export default {
    components:{ValidationErrors, BreezeAuthenticatedLayout,SubMenuLink, Multiselect},
    props:{
        errors:Object,
        contractors:Object,
        expensesTypes:Object,
        expense:Object
    },
    name: "Edit",
    data(){
        return {
            expenseObj: {
                date: this.expense.date,
                contractor: this.expense.contractor.id,
                type: this.expense.type.id,
                sum: this.expense.sum,
                comment: this.expense.comment
            },
            listContractors: this.contractors,
            listTypes: this.expensesTypes
        }
    },
    methods: {
        submit() {
            Inertia.put(route('expenses.update',this.expense.id), this.expenseObj)
        }
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>

</style>
