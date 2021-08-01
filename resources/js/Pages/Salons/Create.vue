<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Создать салон
            </h2>
        </template>
        <form class="w-full max-w-lg" @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                        Название салона
                    </label>
                    <input
                        v-model="form.name"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" type="text" placeholder="Название салона" required>
                </div>
            </div>
            <div class="w-full mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                    Администратор салона
                </label>
                <div class="relative">
                    <select
                        v-model="form.user_id"
                        required
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                        <option v-for="user in users" :key="user.id" :value="user.id">{{user.email}}</option>
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

export default {
    components:{BreezeAuthenticatedLayout},
    props:{
        users:Object,
        errors:Object
    },
name: "Create",
    setup () {
        const form = reactive({
            name: null,
            user_id: null,
        })

        function submit() {
            Inertia.post(route('salons.store'), this.form)
        }

        return { form, submit }
    },
}
</script>

<style scoped>

</style>
