<template>
    <inertia-link :href="href" :class="classes">
        <slot />
    </inertia-link>
</template>

<script>
export default {
name: "SubMenuLink",
    props: ['href', 'active'],

    computed: {
        classes() {
            return this.active
                ? 'active-tab-link'
                : 'tab-link'
        }
    }
}
</script>

<style scoped>

</style>
