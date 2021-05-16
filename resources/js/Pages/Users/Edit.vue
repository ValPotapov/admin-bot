<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Обновить пользователя {{user.name}}
            </h2>
        </template>
        <ValidationErrors/>
        <form class="w-full max-w-lg" @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="name">
                        Название пользователя
                    </label>
                    <input
                        v-model="form.name"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="name" type="text" required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="email">
                        Email
                    </label>
                    <input
                        v-model="form.email"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="email"
                        type="email"
                        required
                    >
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                        Пароль
                    </label>
                    <input
                        v-model="form.password"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="password"
                        type="password"
                    >
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="password">
                        Подтвердите пароль
                    </label>
                    <input
                        v-model="form.password_confirmation"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="password_confirmation"
                        type="password"
                        >
                </div>
            </div>
            <div class="w-full mb-6 md:mb-0">
                <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="grid-state">
                    Роль пользователя
                </label>
                <div class="relative">
                    <select
                        v-model="form.role"
                        required
                        class="block appearance-none w-full bg-gray-200 border border-gray-200 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500" id="grid-state">
                        <option v-for="role in roles" :key="role.id" :value="role.name">{{role.name}}</option>
                    </select>
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
import ValidationErrors from "@/Components/ValidationErrors";

export default {
    components:{ValidationErrors, BreezeAuthenticatedLayout},
    props:{
        user:Object,
        roles:Object,
        errors:Object
    },
    name: "Create",
    mounted(){
        console.log(this.user)
    },
    setup (props) {
        const activeRole =  props.roles.filter(role => role.name === props.user.roles[0].name)
        const form = reactive({
            name: props.user.name,
            role: activeRole[0].name,
            email:props.user.email,
            password:null,
            password_confirmation:null
        })

        function submit() {
            Inertia.put(route('users.update', props.user.id), this.form)
        }

        return { form, submit }
    },
}
</script>

<style scoped>

</style>
