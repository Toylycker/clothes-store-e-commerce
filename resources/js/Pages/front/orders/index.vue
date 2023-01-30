<template>
    <div class="container">
        
    </div>
    <n-card class="container w-100"  title="Song of" style="margin-bottom: 16px">
    <n-tabs default-value="Order paid" justify-content="space-evenly" type="line" animated>
      <n-tab-pane name="Order paid" tab="paid">
        Order paid
      </n-tab-pane>
      <n-tab-pane name="Order accepted" tab="accepted">
        Order accepted
      </n-tab-pane>
      <n-tab-pane name="Order Sent and on it is way" tab="Sent and on its way">
        Order Sent and on its way
      </n-tab-pane>
      <n-tab-pane name="Review" tab="Received and waiting Review">
        Review
      </n-tab-pane>
    </n-tabs>
  </n-card>
        

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NTabs, NTabPane, NCard } from 'naive-ui';
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
