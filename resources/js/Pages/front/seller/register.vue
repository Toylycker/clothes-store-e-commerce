<template>
    <div class="container-xxl py-3">
        <div class="d-block h4 text-danger text-center border-bottom py-2 mb-3">
            Register Seller
        </div>
        {{ form }}
        <div class="row justify-content-center">
            <div class="col-sm-6 col-lg-4">
                <form @submit.prevent="form.post(route('seller.store'))" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">('app.name')</label>
                        <input v-model="form.seller_name" type="text" class="form-control" name="name" id="name" autofocus>
                    </div>
                    <div class="mb-3">
                        <label for="last_name" class="form-label">('app.last_name')</label>
                        <input v-model="form.seller_last_name" type="text" class="form-control" name="last_name" id="last_name"
                            autocomplete="off" aria-describedby="last_nameHelp">
                    </div>
                    <div class="mb-3">
                        <label for="company_name" class="form-label">('app.company_name')</label>
                        <input v-model="form.company_name" type="text" class="form-control" name="company_name" id="company_name"
                            autocomplete="off" aria-describedby="company_nameHelp">
                    </div>

                    <div class="mb-3   ">
                        <label for="location_id" class="form-label fw-bold w-100">
                            ('app.location') <span class="text-danger">*</span>
                            <n-select label-field="name"
      value-field="id" v-model:value="form.location_id" :options="locations" />
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">('app.address')</label>
                        <input v-model="form.shop_address" type="text" class="form-control " name="address"
                            id="address" autofocus>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">('app.phone')</label>
                        <input v-model="form.seller_phone" type="number" class="form-control " name="phone"
                            id="phone" autofocus>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> ('register')
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
    import {
        NSelect
    } from 'naive-ui'
    import {
        Link,
        useForm
    } from '@inertiajs/inertia-vue3';
    import {
        ref,
        watch
    } from '@vue/runtime-core';
    import {
        Inertia
    } from '@inertiajs/inertia';
    import Nav from '@/Shared/Nav.vue';
    const props = defineProps(['locations']);
    const form = useForm({        
        'location_id': null,
        'seller_name': null,
        'seller_last_name': null,
        'seller_phone': null,
        'shop_address': null,
        'company_name': null,
});
</script>
<script>
    import FrontLayout from '@/Layouts/frontLayout.vue';
    export default {
        layout: FrontLayout
    }
</script>
