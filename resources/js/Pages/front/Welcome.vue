<template>
    <Head title="Welcome" />
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NSpace, NLayout, NSwitch, NLayoutSider, NMenu, NTreeSelect, NLayoutFooter, NLayoutHeader, NH2 } from 'naive-ui'


defineProps({
})
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style scoped>
</style>
