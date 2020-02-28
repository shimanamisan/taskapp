<template>
  <div class="c-task--sidebar__wrapp">
    <div class="c-task--sidebar__user">
      <output>
        <div class="c-task__avater" v-if="this.img">
          <img :src="this.img" alt="">
        </div>
        <div class="c-task__avater" v-else>
          <img :src="this.dummy" alt="">
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
      img: '',
      dummy: 'https://placehold.jp/150x150.png',
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