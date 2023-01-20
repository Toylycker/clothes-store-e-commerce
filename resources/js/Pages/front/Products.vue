<template >
    <div class="div">
            <n-layout has-sider position="absolute">
                <n-layout-sider position="absolute" bordered collapse-mode="width" :collapsed-width="10" :width="240" :collapsed="collapsed"
                 :show-collapsed-content=false 
                    show-trigger @collapse="collapsed = true" @expand="collapsed = false">
    
                    <n-tree-select class="mt-1" :show-path="true" placeholder='kategoriya saylang' :default-value="category_id?parseInt(category_id):null"
                        :options="categories.data" children-field="children" key-field="id" label-field="name"
                        @update:value="handleUpdateValue" />
    
                    <!-- filter start -->
                    <div class="container mt-3" v-if="category_id&&options">
                        <form @submit.prevent="form.get(route('outfit.home'), {c:category_id})" method="get">
                            <div class="accordion-item" v-for="option in options" :key="option.id">
                                <h2 class="accordion-header" :id="'panelsStayOpen-heading-o'+ option.id">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        :data-bs-target="'#panelsStayOpen-collapse-o'+option.id" aria-expanded="false"
                                        :aria-controls="'panelsStayOpen-collapse-o'+option.id ">
                                        {{ option.name }}
                                    </button>
                                </h2>
                                <div :id="'panelsStayOpen-collapse-o'+option.id" class="accordion-collapse"
                                    :aria-labelledby="'panelsStayOpen-heading-o'+ option.id">
                                    <div class="accordion-body px-2 py-1">
                                        <div class="form-check my-2" v-for="value in option.values" :key="value.id">
                                            <input class="form-check-input" type="checkbox" v-model="form.values" :value='value.id'>
                                            <label class="form-check-label">{{ value.name}}</label>
                                        </div>
                                        <!-- <input type="hidden" name="c" value="{{category_id}}"> -->
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- filter end  -->
                </n-layout-sider>
                <n-layout>
                    <Nav/>
                        <div
                            class="m-3 row row-cols-2 row-cols-sm-2 row-cols-md-4 row-cols-lg-5 row-cols-xl-6 rounded d-flex justify-content-center">
                            <div class="shadow rounded col m-2" v-for="product in products.data" :key="product.id">
                                <img :src="'/img/temp/outfit.png'" alt="" class="img-fluid border rounded">
                                <div>
                                    <Link :href="route('outfit.show', [product.id, product.seller.id])"
                                        class="d-block link-dark small fw-bold my-1 line-clamp-2" style="height:2.5rem;">
                                    {{ product.name }}></Link>
                                    <div class="container overflow-auto" style="height:100px;">
                                        <p>{{product.price}}</p>
                                        <p>{{product.description}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                </n-layout>
            </n-layout>
    </div>
</template>
<script setup>
import { NSpace, NLayout, NSwitch, NLayoutSider, NMenu, NTreeSelect } from 'naive-ui'
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';
import Nav from '@/Shared/Nav.vue';
const props = defineProps(["options",
    "products",
    "search",
    "f_values",
    "categories",
    "category_id"]);

    // category id for watcher which actually issigned when category changed in NtreeSelect so that watcher can take correct category id right away 
    let categoryIdForFilter = props.category_id

    const form = useForm(
        {
            // to make filter available when rendomly accessed with f_values 
            values:props.f_values
        }
    );

let collapsed = ref(true);

function handleUpdateValue(id) {
    console.log('i am only when category changed');
    Inertia.get('/outfits/home',{c:id}, { preserveState: true, replace: true });
    // to clean form.values after category changed 
    categoryIdForFilter = id;
    form.values=[];
}

watch([form], ([newValues], [prevValues],) => {
    console.log(props.category_id);
    console.log('values watcher');
    console.log(categoryIdForFilter);
    Inertia.get('/outfits/home',{c:categoryIdForFilter, v:form.values}, { preserveState: true, replace: true });
})
</script>
<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>


<!-- :render-label="renderMenuLabel" :render-icon="renderMenuIcon" :expand-icon="expandIcon"  -->

                <!-- <n-menu :collapsed="collapsed" :collapsed-width="0" :collapsed-icon-size="0" :options="categories.data"
                    key-field="id" label-field="name" children-field="children" value="id"
                    @update:value="handleUpdateValue" /> -->