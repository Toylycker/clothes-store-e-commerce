<template>
    <div class=" justify-content-between align-items-center pt-3 pb-2 mb-3">
        <div class="container-fluid d-flex">
            <h1 class="h2">Users</h1>
        </div>
        <div class="container">
            <n-scrollbar x-scrollable>
                <div class="d-flex" style="white-space: nowrap; padding: 12px">
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="all users" :value="all_users">
                            <template #prefix>
                                <n-icon>
                                    <md-save />
                                </n-icon>
                            </template>
                            <template #suffix>
                            </template>
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="only users" :value="only_users">
                            <template #prefix>
                                <n-icon>
                                    <md-save />
                                </n-icon>
                            </template>
                            <template #suffix>
                            </template>
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="sellers" :value="sellers">
                            <template #prefix>
                                <n-icon>
                                    <md-save />
                                </n-icon>
                            </template>
                            <template #suffix>
                                / {{all_users}}
                            </template>
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="deliverymans" :value="deliverymans">
                            <template #prefix>
                                <n-icon>
                                    <md-save />
                                </n-icon>
                            </template>
                            <template #suffix>
                                / {{all_users}}
                            </template>
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="admins" :value="admins">
                            <template #prefix>
                                <n-icon>
                                    <md-save />
                                </n-icon>
                            </template>
                            <template #suffix>
                                / {{all_users}}
                            </template>
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3" style="height:100px;">
                            <canvas id="usersChart" width="100" height="100" aria-label="Hello ARIA World"><p>hello world</p></canvas>
                        </div>
                    
                </div>
            </n-scrollbar>
        </div>
    </div>
    <div class=" justify-content-between align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2">General</h1>
        <div class="container">
            <n-scrollbar x-scrollable>
                <div class="d-flex" style="white-space: nowrap; padding: 12px">
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="Categories" :value="categories">
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="Tags" :value="tags">
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="Options" :value="options">
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="Options' values" :value="values">

                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="Variations" :value="variations">
                        </n-statistic>
                    </div>
                    <div class="container border mx-1 rounded-3">
                        <n-statistic label="Variations' options" :value="variation_options">
                        </n-statistic>
                    </div>
                    
                </div>
            </n-scrollbar>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import { NScrollbar, NStatistic, NIcon  } from 'naive-ui';
import { MdSave } from '@vicons/ionicons4';
import { onMounted } from '@vue/runtime-core';

import Chart from 'chart.js/auto';

const props = defineProps(['all_users', 'sellers', 'deliverymans', 'admins','only_users',
                            'categories','tags','options','values','variations','variation_options',
]);
onMounted(() => {
    const ctx = document.getElementById('usersChart');

    const usersChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
    //   labels: ['Sellers', 'Only Users', 'Deliverymans', 'admins'],
      datasets: [{
        label: 'sany',
        data: [props.sellers,props.only_users, props.deliverymans, props.admins],
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });

})

</script>

<script>
import AdminLayout from '@/Layouts/adminLayout.vue';
export default { layout: AdminLayout }
</script>