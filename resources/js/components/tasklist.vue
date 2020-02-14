<template>
  <div class="c-task--todo--list">
    {{items.title}}
    <div class="c-task--todo--list--del">
      <i class="fas fa-times"></i>
    </div>
  </div>
</template>

<script>

export default {
  data(){
    return {

    }
  },
  props:['items'],

}
</script>

<style>

</style>