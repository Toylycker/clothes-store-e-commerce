<template>
    <Head title="Welcome" />
    <h1 v-if="$page.props.auth.user">Hello {{$page.props.auth.user.name}}</h1>
    <h1 v-else>Hello</h1>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NSpace, NLayout, NSwitch, NLayoutSider, NMenu, NTreeSelect, NLayoutFooter, NLayoutHeader, NH2 } from 'naive-ui'

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>
