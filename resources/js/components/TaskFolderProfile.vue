<template>
  <div class="c-task--sidebar__wrapp">
    <div class="c-task--sidebar__user">
      <output>
        <div class="c-task__avater">
          <img :src="this.img" alt="">
        </div>
      </output>
      <h1 class="c-task--sidebar__usertitle">{{ username }}</h1>
    </div>
  </div><!-- c-task--sidebar__wrapp -->
</template>

<script>
export default {
  data(){
    return{
      img: ''
    }
  },
  computed:{
    username(){
    return this.$store.getters['auth/getUserName']
    }
  },
  methods: {
    profileimage(){
        axios.get('/api/user').then(response => {
        this.img = response.data.pic
        }).catch({
        // error
      })
    }
  },
  created(){
    this.profileimage()
  }
}
</script>

<style>

</style>