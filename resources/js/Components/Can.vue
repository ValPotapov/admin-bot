<template >
    <template v-if="$page.props.permissions.find(per => per.name === permission)">
        <slot/>
    </template>

</template>

<script>
export default {
    props:{
      permission:String
    },
    name: "Can",
    // mounted() {
    //     console.log($page.props.permissions)
    // }
}
</script>

<style scoped>

</style>
