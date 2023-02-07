<template>
    <div class="container">
        <h1>Your chats</h1>
        <div class="container m-2 border rounded-3" v-for="chat in chats" :key="chat.id" @click="$inertia.get(route('get.conversation', chat.id))">
            <div v-for="receiver in chat.users" :key="receiver.name">
                <h5 v-if="receiver.name!=$page.props.auth.user.name">
                    {{receiver.name}}
                </h5>
            </div>
        </div>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NInputNumber, NCheckbox, NCheckboxGroup, NButton } from 'naive-ui';
import { computed, ref } from '@vue/runtime-core';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps(['chats']);
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>