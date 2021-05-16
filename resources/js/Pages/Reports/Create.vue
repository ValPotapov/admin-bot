<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Создать отчет
            </h2>
        </template>
        <ValidationErrors/>
        <form class="w-full max-w-lg" @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="phone">
                        Номер телефона
                    </label>
                    <input
                        v-model="form.phone"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="phone"
                        type="text"
                        required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="number_calls">
                        Кол-во звонков
                    </label>
                    <input
                        v-model="form.number_calls"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="number_calls"
                        type="number"
                        required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="came">
                        Пришли
                    </label>
                    <input
                        v-model="form.came"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="came"
                        type="number"
                        required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="stayed">
                        Остались
                    </label>
                    <input
                        v-model="form.stayed"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="stayed"
                        type="number"
                        required>
                </div>
            </div>
            <div class="w-full mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                    Салон
                </label>
                <div class="relative">
                    <select
                        v-model="form.salon_id"
                        required
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                        <option v-for="salon in salons" :key="salon.id" :value="salon.id">{{salon.name}}</option>
                    </select>
                </div>
            </div>
            <button class="btn-success m-0 mt-5 bg-rose-600">Создать</button>
        </form>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import SubMenuLink from "@/Components/SubMenuLink";
import ValidationErrors from "@/Components/ValidationErrors";

export default {
    components:{ValidationErrors, BreezeAuthenticatedLayout,SubMenuLink},
    props:{
        salons:Object,
        errors:Object
    },
    name: "Create",
    setup () {
        const form = reactive({
            salon_id: null,
            phone: null,
            number_calls:null,
            came:null,
            stayed:null,
        })

        function submit() {
            Inertia.post(route('reports.store'), this.form)
        }

        return { form, submit }
    },
}
</script>

<style scoped>

</style>
