<template>
  <nav class="navbar navbar-expand-md navbar-light bg-light">
    <div class="container-fluid">
      <Link class="navbar-brand" id="jahankeshde" :href="route('outfits.home')">Geyinjek</Link>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-toggle="collapse"
        data-bs-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false"
        aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <!-- <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('home')">Home</Link>
          </li> -->
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Products' }" aria-current="page"
              :href="route('outfits.home')">Products</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/orders/index' }" aria-current="page"
              :href="route('orders')">Orders</Link>
          </li>
          <div v-if="$page.props.auth.user">
            <li v-if="$page.props.auth.user.role == 'user'" class="nav-item">
              <Link class="nav-link" :class="{ 'active': $page.component == 'front/seller/register' }"
                aria-current="page" :href="route('seller.register')">register seller</Link>
            </li>
          </div>
          <div v-if="$page.props.auth.user">
            <li v-if="$page.props.auth.user.role == 'seller'" class="nav-item">
              <Link class="nav-link" :class="{ 'active': $page.component == 'front/seller/CreateProduct' }"
                aria-current="page" :href="route('seller.create.product')">create new product</Link>
            </li>
          </div>
          <div v-if="$page.props.auth.user">
            <li v-if="$page.props.auth.user.role == 'seller'" class="nav-item">
              <Link class="nav-link" :class="{ 'active': $page.component == 'front/seller/SellerDashboard' }"
                aria-current="page" :href="route('seller.dashboard')">Seller Dashbaord</Link>
            </li>
          </div>
          <div v-if="$page.props.auth.user == null || $page.props.auth.user == undefined">
            <li class="nav-item">
              <Link class="nav-link" aria-current="page" :href="route('register')">Login/Register</Link>
            </li>
          </div>
          <div v-if="$page.props.auth.user">
            <li class="nav-item">
              <Link class="nav-link btn" aria-current="page" :href="route('logout')" method="Post" as="button">logout
              </Link>
            </li>
          </div>
          <div v-if="$page.props.auth.user">
            <li class="nav-item">
              <Link class="nav-link btn" aria-current="page" :href="route('chats')" method="Get" as="button">Chats
              </Link>
            </li>
          </div>
        </ul>
        <Link class="nav-link" :class="{ 'active': $page.component == 'front/basket/index' }" aria-current="page"
          :href="route('shopcart')">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-bag-check"
          viewBox="0 0 16 16">
          <path fill-rule="evenodd"
            d="M10.854 8.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L7.5 10.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
          <path
            d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
        </svg>
        </Link>
      </div>
    </div>
  </nav>
</template>
<script setup>
import { Link } from '@inertiajs/inertia-vue3';
</script>
<style lang="">
    
</style>