<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Создать отчет
            </h2>
        </template>
        <ValidationErrors/>
        <form class="w-full" @submit.prevent="submit">
            <div class="flex flex-wrap max-w-lg -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="salon">
                        Салон
                    </label>
                    <Multiselect
                        :searchable="true"
                        v-model="form.salon_id"
                        :options="salons"
                        label="name"
                        valueProp="id"
                        trackBy="name"
                        id="salon"
                        @change="change"
                    >

                    </Multiselect>
                </div>
            </div>
            <div class="flex flex-wrap max-w-lg -mx-3 mb-6">
                <div class="w-full px-3">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2" for="date">
                        Дата
                    </label>
                    <input
                        v-model="form.date"
                        id="date"
                        type="date"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        required
                    />

                </div>
            </div>
            <div class="grid grid-cols-6 gap-4">
                <div>Источник</div>
                <div>Звонков</div>
                <div>Пришли</div>
                <div>Остались</div>
                <div>Сумма</div>
                <div>Причина</div>
            </div>
            <hr class="mb-5">
            <div class="grid grid-cols-6 gap-4" v-for="(source,index) in sources" :key="source.id">

                <div class="flex flex-wrap mb-6" :data="form.sources_id[index] = source.id">
                    <input
                        v-model="form.sources[index]"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="text"
                        :placeholder="source.name"/>
                </div>
                <div class="flex flex-wrap  mb-6">
                    <input
                        v-model="form.number_calls[index]"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="number"
                        @change="onChangeNumberCalls"

                        required
                    />
                </div>
                <div class="flex flex-wrap mb-6">
                    <input
                        v-model="form.came[index]"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="number"
                        required
                        @change="onChangeCame"
                    />
                </div>
                <div class="flex flex-wrap mb-6">
                    <input
                        v-model="form.stayed[index]"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="number"
                        required
                        @change="onChangeStayed"
                    />
                </div>
                <div class="flex flex-wrap mb-6">
                    <input
                        v-model="form.sum[index]"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="number"
                        required
                        step="any"
                        @change="onChangeSum"
                    />
                </div>
                <div class="flex flex-wrap mb-6">
                    <input
                        v-model="form.cause[index]"
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-3 px-4 leading-tight focus:outline-none focus:bg-white focus:border-gray-500"
                        type="text"
                        name="cause"
                    />
                </div>
            </div>
            <div class="grid grid-cols-6 gap-4" v-show="sources.length">

                <div class="flex flex-wrap mb-6">
                    Итого
                </div>
                <div class="flex flex-wrap  mb-6">
                    {{ sum_number_calls }}
                </div>
                <div class="flex flex-wrap mb-6">
                    {{ sum_came }}
                </div>
                <div class="flex flex-wrap mb-6">
                    {{ sum_stayed }}
                </div>
                <div class="flex flex-wrap mb-6">
                    {{ sum_sum }}
                </div>
            </div>
            <hr>
            <div class="grid grid-cols-4 gap-4 mb-6" v-show="sources.length">
                <template v-for="(image,index) in form.images">
                    <div>
                        <InputFile
                            v-model="form.images[index]"
                            :required="index === 0"
                            :show-image="form.images[index].length"/>
                        <span
                            class="text-red-500 cursor-pointer hover:text-red-800"
                            v-if="form.images[index].length"
                            @click="()=>form.images.splice(index,1)">
                            Удалить
                        </span>
                    </div>
                </template>
                <div>
                    <button class="btn-success m-0 mt-5 bg-rose-600"
                            @click.prevent="()=>form.images.push(form.images.length)"
                            v-show="sources.length">Добавить изображение</button>
                </div>
            </div>
            <hr>
            <div class="flex justify-between" v-show="sources.length">
                <button class="btn-success m-0 mt-5 bg-rose-600" >Создать</button>
                <button
                    @click.prevent="()=>form.fixed = 1"
                    class="btn-success m-0 mt-5 bg-rose-600 disabled:opacity-10"
                    :disabled="form.fixed === 1">
                    {{form.fixed === 0?'Фиксировать':'Фиксирован'}}
                </button>
            </div>
        </form>
    </breeze-authenticated-layout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated";
import {reactive} from 'vue'
import {Inertia} from '@inertiajs/inertia'
import SubMenuLink from "@/Components/SubMenuLink";
import ValidationErrors from "@/Components/ValidationErrors";
import Multiselect from '@vueform/multiselect'
import Input from "@/Components/Input";
import InputFile from "@/Components/InputFile";

export default {
    components: {InputFile, Input, ValidationErrors, BreezeAuthenticatedLayout, SubMenuLink, Multiselect},
    props: {
        salons: Object,
        errors: Object
    },
    data() {
        return {
            sources: [],
            form: {
                salon_id: this.salons[0].id,
                number_calls: [],
                came: [],
                stayed: [],
                sum: [],
                date: new Date().toISOString().slice(0, 10),
                sources: [],
                cause: [],
                images:[0],
                fixed:0,
                sources_id: []
            },
            sum_number_calls: 0,
            sum_came: 0,
            sum_stayed: 0,
            sum_sum: 0,
        }
    },
   mounted() {
        this.change(this.form.salon_id)
   },
    methods: {
        change(value) {
            axios.get(route('getSources', value))
                .then(response => response.data)
                .then(data => {
                    this.sources = data
                })
        },
        submit() {
            Inertia.post(route('reports.store'), this.form)
        },
        onChangeNumberCalls() {
            let sum = 0
            this.form.number_calls.forEach(value => {
                sum += parseInt(value)
            })
            this.sum_number_calls = sum
        },
        onChangeCame() {
            let sum = 0
            this.form.came.forEach(value => {
                sum += parseInt(value)
            })
            this.sum_came = sum
        },
        onChangeStayed() {
            let sum = 0
            this.form.stayed.forEach(value => {
                sum += parseInt(value)
            })
            this.sum_stayed = sum
        },
        onChangeSum() {
            let sum = 0
            this.form.sum.forEach(value => {
                sum += parseFloat(value)
            })
            this.sum_sum = sum
        },

    },
    name: "Create",
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
<style scoped>

</style>
