<template>
    
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">locations</h1>
        <div>
            <a class="btn btn-danger btn-sm" :href="route('admin.locations.index')"
               onclick="event.preventDefault(); document.getElementById('locationForm').submit();">
                Submit
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-hover table-bordered table-sm table-striped">
            <thead>
            <tr class="fw-bold">
                <td>ID</td>
                <td>name</td>
                
            </tr>
            <tr>
                <form :action="route('admin.locations.index')" id="locationForm">
                <td>
                    <input type="text" class="form-control form-control-sm" name="id" id="id" value=" id " maxlength="10">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="name" id="name" value=" name " maxlength="10">
                </td>
                <td>
                    <input type="text" class="form-control form-control-sm" name="name_en" id="name_en" value=" name_en " maxlength="10">
                </td>
                
                </form>
            </tr>
            </thead>
            <tbody>
            <div>
                <tr v-for="location in locations" :key="location.id">
                    <td> {{location.id}} </td>
                    <td> {{location.name}} </td>
                </tr>
            </div>
            </tbody>
        </table>
    </div>

</template>

<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps([locations]);

</script>

<script>
import FrontLayout from '@/Layouts/frontLayout.vue';
export default { layout: FrontLayout }
</script>