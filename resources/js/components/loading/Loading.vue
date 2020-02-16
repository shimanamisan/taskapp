<template>
  <div class="container">
    <div class="fullView">
      <vue-loading type="spiningDubbles" :size="{ width: '100px', height: '100px' }"></vue-loading>
      <p>Loading...</p>
    </div>
  </div>
</template>

<script>
import { VueLoading } from 'vue-loading-template'
export default {
  components: {
    VueLoading
  }
}
</script>

<style>
.fullView{
  color: rgb(90, 193, 221);
  width: 100%;
  height: 100%;
  position: fixed;
  top: 0;
  left: 0;

}
</style>