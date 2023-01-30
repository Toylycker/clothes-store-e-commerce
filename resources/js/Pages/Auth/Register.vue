<template>
    <h1>{{ $page.props.errors }}</h1>
    <n-card class="container-fluid d-flex align-items-center justify-content-center">
        <n-tabs class="flex-grow-1" default-value="signin" size="large" animated style="margin: 0 -4px"
            pane-style="padding-left: 4px; padding-right: 4px; box-sizing: border-box;">
            <n-tab-pane name="signin" tab="Sign in">
                <n-form>
                    <n-form-item-row label="name">
                        <n-input />
                    </n-form-item-row>
                    <n-form-item-row label="Password">
                        <n-input />
                    </n-form-item-row>
                </n-form>
                <n-button type="primary" block secondary strong>
                    Sign In
                </n-button>
            </n-tab-pane>
            <n-tab-pane name="signup" tab="Sign up">
                <n-form>
                    <n-form-item-row label="name">
                        <n-input v-model:value="register.name" />
                    </n-form-item-row>
                    <n-form-item-row label="Email">
                        <n-auto-complete v-model:value="register.email" :input-props="{
                            autocomplete: 'disabled'
                        }" :options="options" placeholder="Email" />
                    </n-form-item-row>
                    <n-form-item-row label="Address">
                        <n-input v-model:value="register.address" />
                    </n-form-item-row>
                    <n-form-item-row label="Phone">
                        <n-input-group>
                            <n-button >
                                +
                            </n-button>
                            <n-input v-model:value="register.phone" />
                        </n-input-group>
                    </n-form-item-row>
                    <n-form-item-row label="Password">
                        <n-input v-model:value="register.password" />
                    </n-form-item-row>
                    <n-form-item-row label="Reenter Password">
                        <n-input v-model:value="register.password_confirmation" />
                    </n-form-item-row>
                </n-form>
                <n-button @click="submitRegister" type="primary" block secondary strong>
                    Sign up
                </n-button>
            </n-tab-pane>
        </n-tabs>
    </n-card>

</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { computed, ref } from '@vue/runtime-core';
import { NTab, NForm, NFormItemRow, 
    NCard, NInput, NTabPane, NTabs, NAutoComplete,
    NButton, NInputGroup } from 'naive-ui'

const register = useForm({
    name: '',
    email: '',
    phone: '',
    address: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const login = useForm({
    email: '',
    password: '',
});

const options = computed(() => {
    return ['@gmail.com', '@163.com', '@qq.com'].map((suffix) => {
        const prefix = register.email.split('@')[0]
        return {
            label: prefix + suffix,
            value: prefix + suffix
        }
    })
});

const submitLogin = () => {
    login.post(route('register'), {
        onFinish: () => login.reset('password'),
    });
};

const submitRegister = () => {
    console.log('iam here');
    register.post(route('register'), {
        onFinish: () => register.reset('password', 'password_confirmation'),
    });
};
</script>

<style scoped>
.card-tabs .n-tabs-nav--bar-type {
    padding-left: 4px;
}
</style>