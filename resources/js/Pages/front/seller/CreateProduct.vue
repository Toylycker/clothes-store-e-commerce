<template>
    <h1>Create Product</h1>
    <p> {{ $page.props.errors }}</p>
    <n-steps vertical :current="currentRef" :status="currentStatus">
        <n-step :disabled="currentRef != 1" title="Choose Category" description="Choose category of your product">
            <n-space vertical>
                <n-select :disabled="currentRef != 1" children-field='' label-field="name" value-field="id"
                    v-model:value="main" :options="categories" />
            </n-space>
            <n-space v-if="main" vertical>
                <div v-for="category in categories" :key="category.id">
                    <div v-if="category.id == main && category.children.length >= 1">
                        <n-select :disabled="currentRef != 1" children-field='' label-field="name" value-field="id"
                            v-model:value="secondary" :options="category.children" />

                        <n-space v-if="secondary" vertical>
                            <div v-for="category2 in category.children" :key="category2.id">
                                <div v-if="category2.id == secondary && category2.children.length >= 1">
                                    <n-select :disabled="currentRef != 1" children-field='' label-field="name"
                                        value-field="id" v-model:value="third" :options="category2.children" />

                                    <n-space v-if="third" vertical>
                                        <div v-for="category3 in category2.children" :key="category3.id">
                                            <div v-if="category3.id == third && category3.children.length >= 1">
                                                <n-select :disabled="currentRef != 1" children-field=''
                                                    label-field="name" value-field="id" v-model:value="fourth"
                                                    :options="category3.children" />

                                                <n-space v-if="fourth" vertical>
                                                    <div v-for="category4 in category3.children" :key="category4.id">
                                                        <div
                                                            v-if="category4.id == fourth && category4.children.length >= 1">
                                                            <n-select :disabled="currentRef != 1" children-field=''
                                                                label-field="name" value-field="id"
                                                                v-model:value="fifth" :options="category4.children" />
                                                        </div>
                                                    </div>
                                                </n-space>
                                            </div>
                                        </div>
                                    </n-space>
                                </div>
                            </div>
                        </n-space>
                    </div>
                </div>
            </n-space>
            <n-button-group v-show="currentRef == 1" class="my-2">
                <n-button :disabled="true" @click="prev">
                    prev
                </n-button>
                <n-button :disabled="main == false || main == undefined || main == null || main == 0" @click="next">
                    next
                </n-button>
            </n-button-group>
        </n-step>
        <n-step title="Choose Values" description="Choose which values below corresponds to your product">
            <div class="container" v-if="!options || showFilter == false">
                <n-skeleton class="m-1" height="30px" width="30%" :sharp="false" />
                <div class="container d-flex my-1">
                    <n-skeleton class="m-1" height="30px" width="30px" round />
                    <n-skeleton class="m-1" height="30px" width="13%" />
                </div>
                <div class="container d-flex my-1">
                    <n-skeleton class="m-1" height="30px" width="30px" round />
                    <n-skeleton class="m-1" height="30px" width="13%" />
                </div>
                <div class="container d-flex my-1">
                    <n-skeleton class="m-1" height="30px" width="30px" round />
                    <n-skeleton class="m-1" height="30px" width="13%" />
                </div>
                <div class="container d-flex my-1">
                    <n-skeleton class="m-1" height="30px" width="30px" round />
                    <n-skeleton class="m-1" height="30px" width="13%" />
                </div>
                <div class="container d-flex my-1">
                    <n-skeleton class="m-1" height="30px" width="30px" round />
                    <n-skeleton class="m-1" height="30px" width="13%" />
                </div>
            </div>
            <div v-if="options && showFilter == true" class="container my-3">
                <div class="accordion-item" v-for="option in options[0]" :key="option.id">
                    <h2 class="accordion-header" :id="'panelsStayOpen-heading-o' + option.id">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            :data-bs-target="'#panelsStayOpen-collapse-o' + option.id" aria-expanded="false"
                            :aria-controls="'panelsStayOpen-collapse-o' + option.id">
                            {{ option.name }}
                        </button>
                    </h2>
                    <div :id="'panelsStayOpen-collapse-o' + option.id" class="accordion-collapse"
                        :aria-labelledby="'panelsStayOpen-heading-o' + option.id">
                        <div class="accordion-body px-2 py-1">
                            <div class="form-check my-2" v-for="value in option.values" :key="value.id">
                                <input :disabled="currentRef != 2" class="form-check-input" type="checkbox"
                                    v-model="form.values" :value='value.id'>
                                <label class="form-check-label">{{ value.name }}</label>
                            </div>
                            <!-- <input type="hidden" name="c" value="{{category_id}}"> -->
                        </div>
                    </div>
                </div>
            </div>
            <n-button-group v-show="currentRef == 2" class="my-2">
                <n-button @click="prev">
                    prev
                </n-button>
                <n-button @click="next">
                    next
                </n-button>
            </n-button-group>
        </n-step>
        <n-step title="Create product"
            description="Create your general product, Later you assign it to variations and define quantity and price">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Photo</label>
                <n-upload :disabled="currentRef != 3" :max="1" @input="form.image = $event.target.files[0]"
                    :headers="{ 'naive-info': 'hello!' }" :data="{ 'naive-data': 'cool! naive!' }">
                    <n-button class="w-100 btn">Upload File</n-button>
                </n-upload>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Name</label>
                <input :disabled="currentRef != 3" v-model="form.name" type="text" class="form-control"
                    id="exampleInputName">
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Description</label>
                <textarea :disabled="currentRef != 3" v-model="form.description" class="form-control"
                    aria-label="With textarea"></textarea>
            </div>
            <n-button-group v-show="currentRef == 3" class="my-2">
                <n-button @click="prev">
                    prev
                </n-button>
                <n-button @click="next">
                    next
                </n-button>
            </n-button-group>
        </n-step>
        <n-step title="Attach Variations and Options"
            description="Something in the way she moves Attracts me like no other lover">
            <n-dynamic-input :disabled="currentRef != 4" v-model:value="form.variations" :on-create="onCreate">
                <template #create-button-default>
                    Add variations and its options
                </template>
                <template #default="{ value }">
                    <div style="display: flex; align-items: center; width: 100%">
                        <n-input :disabled="currentRef != 4" class="w-50 mx-2" v-model:value="value.variation"
                            type="text" />
                        <n-dynamic-tags :disabled="currentRef != 4" class="w-50" v-model:value="value.options" />
                    </div>
                </template>
            </n-dynamic-input>
            <n-button-group v-show="currentRef == 4" class="my-2">
                <n-button @click="prev">
                    prev
                </n-button>
                <n-button :disabled="true" @click="next">
                    next
                </n-button>
            </n-button-group>
            <div class="container m-3">
                <n-button class="w-100" type="success" dashed @click="() => {
                    $inertia.post(route('seller.send.to.laststep'),
                        {
                            'values': form.values,
                            'image': form.image,
                            'name': form.name,
                            'description': form.description,
                            'variations': form.variations,
                            'categories': [main, secondary,
                                third, fourth, fifth],
                        });
                }"> Go to the last step</n-button>
            </div>
        </n-step>
    </n-steps>
</template>

<script setup>
import {
    NSelect, NSpace, NCard,
    NTabs, NTabPane, NUpload, NButton,
    NDynamicInput, NInputNumber, NCheckbox,
    NInput, NDynamicTags, NSteps, NStep, NIcon, NButtonGroup,
    NSkeleton
} from 'naive-ui'
import { Link, useForm } from '@inertiajs/inertia-vue3';
import { ref, watch } from '@vue/runtime-core';
import { Inertia } from '@inertiajs/inertia';
import Nav from '@/Shared/Nav.vue';

const props = defineProps(['categories', 'options']);


const showFilter = ref(false);
const currentRef = ref(1);
const currentStatus = ref("process");

let main = ref(null);
let secondary = ref(null);
let third = ref(null);
let fourth = ref(null);
let fifth = ref(null);

const form = useForm({
    //first Tab start
    'values': [],
    // first tab end
    //second tab start
    'image': null,
    'name': null,
    'description': null,
    //seconda tab end
    'variations': [
        {
            variation: '',
            options: []
        }
    ],
});

watch([main], ([newValues], [prevValues],) => {
    secondary.value = null;
    showFilter.value = false;
    form.values = [];
});
watch([secondary], ([newValues], [prevValues],) => {
    third.value = null;
    showFilter.value = false;
    form.values = [];
});
watch([third], ([newValues], [prevValues],) => {
    fourth.value = null;
    showFilter.value = false;
    form.values = [];
});
watch([fourth], ([newValues], [prevValues],) => {
    fifth.value = null;
    showFilter.value = false;
    form.values = [];
});

function onCreate() {
    return {
        variation: '',
        options: []
    }
}

function next() {
    if (currentRef.value === null)
        currentRef.value = 1;
    else if (currentRef.value === 1)
        Inertia.post(route('seller.create.product'),
            { 'validate': 1, 'categories': [main.value, secondary.value, third.value, fourth.value, fifth.value] }, {
            only: ['options'],
            preserveState: true,
            preserveScroll: true,
            onSuccess: () => { showFilter.value = true; form.values = []; currentRef.value++; }
        });
    else if (currentRef.value === 2)
        currentRef.value++;
    else if (currentRef.value === 3)
        currentRef.value++;
    else if (currentRef.value === 4)
        currentRef.value = 4;
}

function prev() {
    if (currentRef.value === 0)
        currentRef.value = null;
    else if (currentRef.value === 1)
        currentRef.value = 1;
    else if (currentRef.value === 2) {
        showFilter.value = false;
        form.values = [];
        currentRef.value--;
    }
    else if (currentRef.value === 3)
        currentRef.value--;
    else if (currentRef.value === 4)
        currentRef.value--;
}

</script>







<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default {
    layout: FrontLayout
}
</script>
