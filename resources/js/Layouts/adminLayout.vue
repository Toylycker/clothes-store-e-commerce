<template>
 <n-layout has-sider>
      <n-layout-sider
        collapse-mode="width"
        :collapsed-width="120"
        :width="240"
        :show-collapsed-content="true"
        show-trigger="arrow-circle"
        content-style="padding: 24px;"
        bordered
      >
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Dashboard</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Categories</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Tags</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Filters</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Products</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Users</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Chats</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Messages</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'admin/delivery/index' }" aria-current="page"
              :href="route('admin.delivery.index')">Delivery</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :class="{ 'active': $page.component == 'front/Welcome' }" aria-current="page"
              :href="route('admin.dashboard')">Telescope</Link>
          </li>
          <br>
          <p>Front layout links</p>
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
      </n-layout-sider>
      <n-layout-content content-style="padding: 24px;">
        <slot></slot>

      </n-layout-content>
    </n-layout>
  </template>
  
  <script setup>
import { Link } from '@inertiajs/inertia-vue3';
  import { NSpace, NLayout, NSwitch, NLayoutSider, NLayoutContent, NMenu, NTreeSelect, NInputGroup, NInput, NButton, NBreadcrumb, NBreadcrumbItem, NRow, NCol, NStatistic } from 'naive-ui'
  
  </script>
  
  <style>
  
  </style>