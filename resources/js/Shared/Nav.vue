<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-toggle="collapse" data-bs-target="#navbarTogglerDemo03"
        aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <Link class="navbar-brand" id="jahankeshde" :href="route('home')">Geyinjek</Link>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('home')">Home</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'Front/Products' }" aria-current="page"
              :href="route('outfits.home')">Products</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('home')">Categories</Link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>
<style lang="">
    
</style>