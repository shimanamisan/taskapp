<template>
  <div class="c-task--todo--list" @click="logfunc">
    {{task.title}}
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
  props: {
    task: {
      type: Object,
      required: true
    },
    id: {
      type: Number,
      required: true
    },
    listIndex: {
      type: Number,
      required: true
    }
  },

  
  computed:{
    
  },
  methods:{
    logfunc(value){
      console.log(value)
    }
  }
}
</script>

<style>

</style>