<template>
    <transition name="fade">
        <div v-if="success && visible"
             class="absolute flex max-w-xs w-full mt-4 mr-4 top-0 right-0 bg-white rounded shadow p-4">
            <div class="mr-2">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <div class="flex-1 text-gray-800">{{ success }}</div>
            <div class="ml-2">
                <button @click="visible = false" class="align-top text-gray-500 hover:text-gray-700 focus:outline-none focus:text-indigo-600">
                    <svg class="w-6 h-6 " fill="none" stroke="currentColor" viewBox="0 0 24 24"
                         xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    name: "toast",

    props: {
        success: String,
    },
    data() {
        return {
            visible: false,
            timeout: null
        }
    },
    watch: {
        success: {
            // the callback will be called immediately after the start of the observation
            immediate: true,
            handler(val, oldVal) {
                this.visible = true

                if(this.timeout){
                    clearTimeout(this.timeout)
                }

                this.timeout = setTimeout(() => this.visible = false, 2000)
            }
        }
    }
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
    transition: opacity .5s;
}

.fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */
{
    opacity: 0;
}
</style>
