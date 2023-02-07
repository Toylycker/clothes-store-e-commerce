<template>
    <div class="container">
        <n-card class="container w-100" title="Your orders" style="margin-bottom: 16px">
            <n-tabs default-value="Waiting to be accepted" justify-content="space-evenly" type="line" animated>
                <n-tab-pane name="Waiting to be accepted" tab="need to accept">
                    <div class=" border rounded-3 my-2 d-flex justify-content-between" v-for="order in paid" :key="order.id">
          {{ order.outfit_item.outfit.name }}
          <div @click="$inertia.post(route('seller.accept.order', order.id))" class="btn btn-success">accept</div>
        </div>
                </n-tab-pane>
                <n-tab-pane name="waiting to be sent" tab="need to send">
                    <div class="container border rounded-3 my-2" v-for="order in accepted" :key="order.id">
          {{ order.outfit_item.outfit.name }}
        </div>
                </n-tab-pane>
                <n-tab-pane name="Order Sent and on it is way" tab="on its way">
                    <div class="container border rounded-3 my-2" v-for="order in sent" :key="order.id">
          {{ order.outfit_item.outfit.name }}
        </div>
                </n-tab-pane>
                <n-tab-pane name="Review" tab="Received and waiting Review">
                    <div class="container border rounded-3 my-2" v-for="order in received" :key="order.id">
          {{ order.outfit_item.outfit.name }}
        </div>
                </n-tab-pane>
            </n-tabs>
        </n-card>
    </div>


</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTabs, NTabPane, NCard } from 'naive-ui';
import { computed, ref } from '@vue/runtime-core';
import { useForm } from '@inertiajs/inertia-vue3';

const props = defineProps(['paid', 'accepted', 'sent', 'received']);

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

