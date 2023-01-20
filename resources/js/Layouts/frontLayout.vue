<template>
  <Nav v-if="$page.component!='front/Products'" />
  <div class="container">
      <slot></slot>
  </div>
</template>

<script setup>
import Nav from '@/Shared/Nav.vue';

</script>

<style>

</style>


<!-- style="background-image:url('/img/carpet.jpg');object-fit: cover; width: 100%;height: 100%;" -->