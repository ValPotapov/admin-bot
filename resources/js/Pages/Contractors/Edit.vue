<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Редактировать контрагента {{contractor.name}}
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


export default {
    components:{ValidationErrors, BreezeAuthenticatedLayout,SubMenuLink},
    props:{
        errors:Object,
        contractor:Object,
    },
    name: "Create",
    setup (props) {
        const form = reactive({
            name:props.contractor.name,
        })

        function submit() {
            Inertia.put(route('contractors.update',props.contractor.id), this.form)
        }

        return { form, submit }
    },
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>

</style>
