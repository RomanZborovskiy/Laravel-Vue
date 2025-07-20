<template>
  <div>Ivz {{user?.name}}</div>
  Home
</template>

<script>
export default {
  data() {
    return {
      user: JSON.parse(localStorage.getItem('user_data')) || null,
    }
  }

}
</script>

<style>

</style>