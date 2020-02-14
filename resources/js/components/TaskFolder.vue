<template>
    <div>
      
        <li class="c-task--folder__wrapp">
            <i class="fas fa-bars c-task--folder__drag hand-icon"></i>
            <label class="c-task--folder__item" for="">{{title}}</label>
            <div class="c-task--folder__trash">
               <i class="fas fa-trash-alt"></i>
            </div>
        </li>
    </div>
</template>
<script>
import draggable from 'vuedraggable'
export default {
  data(){
    return {
    }
  },
  components: {
    draggable
  },
  props: {
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
.c-task--folder__trash {
  display: block;
  float: right;
}

</style>