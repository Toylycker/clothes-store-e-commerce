<template>
    <p>
        {{ form }}
    </p>
    <n-dynamic-input v-model:value="form.items" :on-create="onCreate">
        <template #create-button-default>
            Add variations and its options
        </template>
        <template #default="{ value }">
            <div class="d-flex w-100">
                <n-tree-select v-for="(variation, index) in product.variations" :key="index"
                    v-model:value="value.options[index]" label-field="option" key-field="id"
                    :options="variation.variation_options" />
            </div>
            <n-input-number min="1" v-model:value="value.stock" button-placement="both" />
            <n-input-number min="1" v-model:value="value.price" button-placement="both"><template #prefix>
        $
      </template></n-input-number>

        </template>
    </n-dynamic-input>

    <n-button class="m-2 w-100" dashed type="success" @click="form.post(route('seller.add.item', product.id))" > finish adding items</n-button>


</template>

<script setup>
import {
    NTreeSelect, NSpace, NCard, NTabs, NTabPane, NUpload, NButton,
    NDynamicInput, NInputNumber, NCheckbox, NInput, NDynamicTags
} from 'naive-ui'
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';
import Nav from '@/Shared/Nav.vue';

const props = defineProps(['product']);
const form = useForm({
    'items': [
        {
            stock: null,
            price: null,
            options: {}
        }
    ]
})
function onCreate() {
    return {
        stock: null,
        price: null,
        options: {}
    }
}

let somefunction = (value) => {
    console.log(value);
}


</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default {
    layout: FrontLayout
}
</script>
if (value.options.includes(id)) {
let index = value.options.indexOf(id);
value.options.splice(index, 1);
} else {
value.options.push(id);
}

:on-update:value="(id) => value.options.includes(id)?
value.options.splice(value.options.indexOf(id), 1):value.options.push(id)"

:on-update:value="(key) => somefunction(key, variation.id)"
:on-update:value="(key) => somefunction(key, variation.id)"