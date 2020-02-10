<template>
  <div class="c-task--sidebar__wrapp">
    <div class="c-task--sidebar__user">
      <output>
        <div class="c-task__avater">
          <img :src="profileimage" alt="">
        </div>
      </output>
      <h1 class="c-task--sidebar__usertitle">{{ username }}</h1>
    </div>
  </div><!-- c-task--sidebar__wrapp -->
</template>

<script>
export default {

    computed:{
        username(){
        return this.$store.getters['auth/getUserName']
      },
        profileimage(){
        let img = this.$store.getters['auth/getProfileImage']
        return img
      }
  }
}
</script>

<style>

</style>