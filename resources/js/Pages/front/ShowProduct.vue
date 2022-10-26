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
                {{form.options}}
                <p>{{ product.price }} </p>
            </div>
            <p>{{ product.description }}</p>
            <a href="#" class="d-block h5 fw-bold link-secondary mb-3">
                {{ product.seller.name }}
            </a>
            <p>{{ product.seller.company_name }}</p>
            <p>{{ product.seller.phone }}</p>
            <!-- <p>{{ product.seller.location.name }}</p> -->
            <!-- @foreach (product.tags as $tag)
            <a href="{{ route('results', ['t' => $tag.id]) }}" class="d-block h5 fw-bold link-secondary mb-3">
                <span>{{ $tag.name }}</span>
            </a>
            @endforeach
            @foreach (product.values as $value)
            <a href="#" class="d-block h5 fw-bold link-secondary mb-3">
                <span>{{ $value.name }}</span>
            </a>
            @endforeach -->

            <!-- <div class="h5 fw-bold mb-3">
                    {{-- @if (product.isDiscount())
                        <span class="text-secondary"><s>{{ number_format(product.price, 2, ".", " ") }}</s></span>
                        <span class="text-danger">{{ number_format(product.price(), 2, ".", " ") }} <small>TMT</small></span>
                    @else
                        <span class="text-primary">{{ number_format(product.price, 2, ".", " ") }} <small>TMT</small></span>
                    @endif --}}
                    @if (product.credit)
                        <i class="bi bi-patch-check-fill text-info"></i>
                    @endif
                </div> -->
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
        </div>

        //choosing options
        <div class="col-3">
            <form @submit.prevent="form.post(route('outfit.show', product.id), 
            // {onSuccess: () => form.reset()}
            )" method="POST" id='product_choosing_form'>
                <div class="" v-for="variation in variations" :key="variation.id">
                    <h3> {{ variation.name }} </h3>
                    <br>
                    <div class="row ">
                        <div class="col-4" v-for="ooption in variation.variation_options" :key="ooption.id">
                            <div class="container" v-if="ooption.outfit_items.length > 0">
                                <div class="container" v-if="flattened != null">
                                    <div class="container" v-if="flattened.includes(ooption.id)">
                                        <button @click="manageReq(ooption.id)" :class="{'btn-success':form.options.includes(ooption.id)&&flattened.includes(ooption.id),
                                            'btn-outline-success':flattened.includes(ooption.id)&&form.options.includes(ooption.id)==false
                                        }" class="btn btn-sm choosing">{{ooption.option}}</button>
                                    </div>
                                    <div v-else class="container rounded">
                                        <div class="form-check form-switch">
                                            <button disabled @click="manageReq(ooption.id)"
                                                class="btn btn-sm btn-danger  choosing">{{ooption.option}}</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" v-else>
                                    <div class="form-check form-switch">
                                        <button @click="manageReq(ooption.id)"
                                            class="btn btn-outline-success btn-sm choosing">{{ooption.option}}</button>
                                    </div>
                                </div>
                            </div>
                            <p v-else class="bg-secondary"> {{ ooption.option }} </p>
                        </div>
                    </div>
                </div>
            </form>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 border" v-for="item in product.outfit_items" :key="item.id">
                        .option:
                        <span v-for="option in item.variation_options" :key="option.id">{{ option.option }}///</span>
                    </div>

                </div>
            </div>
            <div class="container ">
                <button v-if="product_items != null && product_items.length==1" class="btn btn-success btn-md">satyn
                    aljak product->id = <span v-for="product_item in product_items" :key="product_item.id">{{product_item.id}}//stock={{product_item.stock}}</span></button>
            </div>
        </div>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { useForm } from '@inertiajs/inertia-vue3'
import { NTag, NButton, NTable, NDropdown, NSelect } from 'naive-ui'

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
    'product_items']);

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