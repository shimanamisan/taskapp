<template>
    <div>
        <li class="c-task--folder__wrapp">
            <i class="fas fa-bars c-task--folder__drag"></i>
            <label class="c-task--folder__item" for="">{{title}}</label>
        </li>
    </div>
</template>
<script>
export default {
  data(){
    return {
    }
  },
  props:{
    title:{
      type: String,
      required: true
    },
  },
  computed: {

  },
  methods: {
  
  }
}
</script>
<style>

</style>