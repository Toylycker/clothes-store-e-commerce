<template>
    <div class="container">
        <h1>{{ form.orders }}</h1>
        <div class="container" >
            <n-button @click="form.post(route('setorder'),{onFinish:()=>{form.orders = []}})" class="w-100" strong round type="warning" size="large">
                {{ ordersSum }}$
            </n-button>
        </div>
        <div class="container shadow m-2 w-100 rounded-3 border border-success" v-for="shopcart in shopcarts"
            :key="shopcart.id">
            <div class="container m-1 h5"> satyjy: {{ shopcart.seller.seller_name }}</div>
            <n-checkbox-group v-model:value="form.orders" @update:value="handleUpdateValue">
                <div class="container m-1" v-for="outfitItem in shopcart.outfit_items" :key="outfitItem.id">
                    <div class="row d-flex justify-content-center">
                        <div class="col-sm-11 col-md-7 border rounded-3">
                            <div class="d-flex align-items-center justify-content-center">
                                <n-checkbox :value="outfitItem.id" />
                                <div class="container">
                                    <p>{{ outfitItem.outfit.name }}</p>
                                    <span v-for="option in outfitItem.variation_options" :key="option.id">
                                        {{ option.option }} --
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-sm-12 col-md-4 border rounded-3 d-flex align-items-center justify-content-center text-center">
                            <p> {{ outfitItem.price }}</p>
                            <n-input-number :disabled="proggressing" class="m-2" :value="outfitItem.pivot.quantity"
                                placeholder="nache sany?" :min="1" :max="outfitItem.stock" :on-update:value="(value) => $inertia.post(route('updatequantity', [outfitItem.id, value]),
                                { onStart: proggressing = true, onFinish: proggressing = false, })" />
                        </div>
                        <button class="col-1 text-center btn d-flex align-items-center" @click="$inertia.delete(route('shopcart.delete', [outfitItem.id]), {
                            onFinish: () => {
                                if (form.orders.includes(outfitItem.id)) {
                                    const index = form.orders.indexOf(outfitItem.id);
                                    if (index > -1) { // only splice array when item is found
                                        form.orders.splice(index, 1); // 2nd parameter means remove one item only
                                    }
                                }
                            }
                        })"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-x-lg" viewBox="0 0 16 16">
                                <path
                                    d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8 2.146 2.854Z" />
                            </svg></button>
                    </div>
                </div>
            </n-checkbox-group>
        </div>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NInputNumber, NCheckbox, NCheckboxGroup, NButton } from 'naive-ui';
import { computed, ref } from '@vue/runtime-core';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps(['shopcarts']);

let proggressing = ref(false);
let ordersSumCollector = ref([]);

const form = useForm(
    {
        orders: [],
    }
);

const ordersSum = computed(() => {
    ordersSumCollector = ref([]);
    form.orders.forEach(order => {
        props.shopcarts.forEach(shopcart => {
            shopcart.outfit_items.forEach(outfitItem => {
                if (outfitItem.id == order) {
                    ordersSumCollector.value.push(outfitItem.price * outfitItem.pivot.quantity);
                }
            });
        });
    });
    return ordersSumCollector.value.reduce((partialSum, a) => partialSum + a, 0);
});

const handleUpdateValue = (value) => {
    form.orders = value;
}

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>