<template>
    <div v-if="!showImage">
        <h2>Выберите изображение</h2>
        <input
            type="file"
            @input="$emit('update:modelValue',
            $event.target.files)"
            :required="required"
            accept="image/*"
        >
    </div>
    <div v-else>
        <img :src="image" />
    </div>
</template>

<script>
export default {
name: "InputFile",
    props: ['modelValue', 'required', 'showImage', 'path',],

    emits: ['update:modelValue'],
    data(){
      return {
          image:this.path
      }
    },
    mounted(){
        console.log(this.path)
    },
    updated() {
        this.onFileChange(this.modelValue)
    },
    methods: {
        onFileChange(files) {
            if (!files.length)
                return;
            this.createImage(files[0]);
        },
        createImage(file) {
            var image = new Image();
            var reader = new FileReader();
            var vm = this;

            reader.onload = (e) => {
                vm.image = e.target.result;
            };
            reader.readAsDataURL(file);
        },
        removeImage: function (e) {
            this.image = '';
        }
    }
}
</script>

<style scoped>

</style>
