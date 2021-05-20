<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Создать источник
            </h2>
        </template>
        <ValidationErrors/>
        <form class="w-full max-w-lg" @submit.prevent="submit">
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="number_calls">
                        Название
                    </label>
                    <input
                        v-model="form.name"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        id="number_calls"
                        type="text"
                        required>
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="salon">
                        Салон (Оставьте пустым будет для всех салонов)
                    </label>
                    <Multiselect
                        mode="tags"
                        :searchable="true"
                        v-model="form.salons"
                        :options="salons"
                        label="name"
                        valueProp="id"
                        trackBy="name"
                        id="salon"
                    >

                    </Multiselect>
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
import Multiselect from '@vueform/multiselect'


export default {
    components:{ValidationErrors, BreezeAuthenticatedLayout,SubMenuLink,Multiselect},
    props:{
        errors:Object,
        salons:Object,
    },
    name: "Create",
    setup (props) {
        const form = reactive({
            name:null,
            salons:null,
        })

        function submit() {
            console.log(this.form)
            Inertia.post(route('sources.store'), this.form)
        }

        return { form, submit }
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>

</style>
