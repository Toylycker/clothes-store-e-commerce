<template>

    <Head title="Product" />
    <div class="row g-3">
        <div class="col-sm-6 col-lg-4">
            <div class="position-relative d-flex justify-content-center align-items-center">
                <img :src="'/img/temp/outfit.png'" alt="" class="img-fluid border rounded">
            </div>
        </div>

        <div class="col-3">
            <div class="d-block h2 fw-bold mb-3">
                {{ product.name }}
                {{ form.options }}
                <p>{{ product.price }} </p>
            </div>
            <p>{{ product.description }}</p>
            <a href="#" class="d-block h5 fw-bold link-secondary mb-3">
                {{ product.seller.name }}
            </a>
            <p>{{ product.seller.company_name }}</p>
            <p>{{ product.seller.seller_phone }}</p>
            <div class="d-flex align-items-center fw-bold mb-3">
                <div class="me-4">
                    <i class="bi bi-basket-fill text-black-50"></i> {{ product.sold }}
                </div>
                <div class="me-4">
                    <i class="bi bi-binoculars-fill text-black-50"></i> {{ product.viewed }}
                </div>
                <a href="#" class="btn btn-danger btn-sm text-decoration-none">
                    <i class="bi bi-heart-fill"></i> {{ product.liked }}
                </a>
            </div>
            <Link :href="route('connect.conversation', product.seller.user.id)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-dots"
                    viewBox="0 0 16 16">
                    <path
                        d="M5 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm4 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                    <path
                        d="m2.165 15.803.02-.004c1.83-.363 2.948-.842 3.468-1.105A9.06 9.06 0 0 0 8 15c4.418 0 8-3.134 8-7s-3.582-7-8-7-8 3.134-8 7c0 1.76.743 3.37 1.97 4.6a10.437 10.437 0 0 1-.524 2.318l-.003.011a10.722 10.722 0 0 1-.244.637c-.079.186.074.394.273.362a21.673 21.673 0 0 0 .693-.125zm.8-3.108a1 1 0 0 0-.287-.801C1.618 10.83 1 9.468 1 8c0-3.192 3.004-6 7-6s7 2.808 7 6c0 3.193-3.004 6-7 6a8.06 8.06 0 0 1-2.088-.272 1 1 0 0 0-.711.074c-.387.196-1.24.57-2.634.893a10.97 10.97 0 0 0 .398-2z" />
                </svg>
            </Link>
        </div>

        <!-- choosing options Start -->
        <div class="col-sm-12 col-md-3 col-lg-5 d-flex justify-content-center">
            <form @submit.prevent="form.post(route('outfit.show', product.id),
                { preserveScroll: true }
            )" method="POST" id='product_choosing_form'>
                <n-button v-if="max != min" class="w-100 my-2" type="info" dashed>
                    {{ min }}$-{{ max }}$
                </n-button>
                <n-button v-if="max === min" class="w-100 my-2" type="info" dashed>
                    {{ max }}$
                </n-button>
                <div class="my-3" v-for="variation in variations" :key="variation.id">
                    <h3> {{ variation.name }} </h3>
                    <div class="row">
                        <div class="col-12" v-for="ooption in variation.variation_options" :key="ooption.id">
                            <div class="container g-0" v-if="ooption.outfit_items.length > 0">
                                <div class="container g-0" v-if="flattened != null">

                                    <div class="container g-0" v-if="flattened.includes(ooption.id)">
                                        <button @click="manageReq(ooption.id)" :class="{
                                            'btn-success': form.options.includes(ooption.id) && flattened.includes(ooption.id),
                                            'btn-outline-success': flattened.includes(ooption.id) && form.options.includes(ooption.id) == false
                                        }" class="btn rounded w-100 my-1">{{ ooption.option }}</button>
                                    </div>

                                    <div v-else class="container g-0 rounded">
                                        <div class="form-check">
                                            <n-button class="w-100 my-1" disabled type="error">
                                                {{ ooption.option }}
                                            </n-button>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" v-else>
                                    <div class="">
                                        <button @click="manageReq(ooption.id)"
                                            class="btn btn-outline-success choosing rounded w-100 my-1">
                                            {{ ooption.option }}</button>

                                    </div>
                                </div>
                            </div>
                            <div class="container g-0" v-else>
                                <n-button class="w-100 my-1" disabled type="tertiary">
                                    {{ ooption.option }}
                                </n-button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- choosing options END -->
                <div class="container g-0 my-3 border rounded"
                    v-if="product_items != null && product_items.length == 1 && variations.length == form.options.length">
                    <div class="container" v-for="product_item in product_items" :key="product_item.id">
                        <div class="d-flex g-3">
                            <n-button class="m-2">{{ product_item.price * quantity }} $</n-button>
                            <n-input-number class="m-2" v-model:value="quantity" placeholder="nache sany?" :min="1"
                                :max="product_item.stock" />
                        </div>
                        <n-button type="success" dashed class="w-100 my-1" @click="$inertia.post(route('additem', product_item.id), { 'quantity': quantity, 'seller': product.seller.id },
                        { onFinish: () => { form.options = []; quantity = 1; } })">
                            Sebede gosh {{ product_item.id }}</n-button>
                    </div>
                </div>
            </form>

            <!-- <div class="container-fluid">
                <div class="row">
                    <div class="col-12 border" v-for="item in product.outfit_items" :key="item.id">
                        .option:
                        <span v-for="option in item.variation_options" :key="option.id">{{ option.option }}///</span>
                    </div>

                </div>
            </div> -->
        </div>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3';
import { NTag, NButton, NInput, NTable, NDropdown, NSelect, NInputNumber } from 'naive-ui';
import { ref } from '@vue/runtime-core';

const form = useForm(
    {
        options: [],

    }
);

defineProps(['product',
    'comments',
    'variations',
    'flattened',
    'chosens',
    'product_items',
    'min',
    'max']);

const quantity = ref(1);

function manageReq(id) {
    if (form.options.includes(id)) {
        let index = form.options.indexOf(id);
        form.options.splice(index, 1);
        form.submit;
    } else {
        form.options.push(id);
        form.submit;
    }
}
</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>

<style scoped>

</style>