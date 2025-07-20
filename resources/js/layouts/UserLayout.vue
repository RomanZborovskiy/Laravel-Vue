<template>
  <div>
    <Menu />
    <main>
      <router-view />
    </main>
    <footer>Основной футер</footer>
  </div>
</template>

<script setup>
  import { defineComponent } from 'vue'
  import { NButton } from 'naive-ui'
  import Menu from '../components/heder/Menu.vue'


</script>

<style>

</style>