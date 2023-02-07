<template>
    <div class="container position-relative">
        <h1>Conversation</h1>
        <div class="container">
            <div class="container" v-for="message in chatMessages" :key="message.id">
                <div class="container border-bottom m-2 rounded-3 position-relative" 
                :class="{'text-end':message.from_id ==$page.props.auth.user.id}">
                    <p>{{message.content}}</p>
                </div>
            </div>
        </div>
        
        <div class="fixed-bottom m-3 text-center">
            <n-input class="w-50 border-warning" v-model:value="form.content" type="text" placeholder="Basic Input" />
            <n-button class="mx-1" dashed type="success"
            @click="form.post(route('new.message', chat.id), {onSuccess:()=>{form.reset()}, preserveScroll:true} )"
            > Send </n-button>
        </div>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NInput, NCheckbox, NCheckboxGroup, NButton } from 'naive-ui';
import { computed, onBeforeUnmount, ref } from '@vue/runtime-core';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps(['messages', 'chat']);

const chatMessages = props.messages;

const form = useForm({
    'content':null,
    'to_id':null
});


Echo.private('chat.'+props.chat.id).listen('NewMessage', e=>{
    chatMessages.push(e.message);
});

onBeforeUnmount(() => {
    Echo.leave('chat.'+props.chat.id);
})
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>