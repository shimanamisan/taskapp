<template>
  <div>
    <!-- ここからTaskList -->
    <div class="c-task--card__inner">
      <div class="c-task--todo">
        <div class="c-task--todo__header">{{ cards.title }}
          <label for="" class="c-task--todo--counter">0</label>
           <div class="c-task--todo--list--del">
      <i class="fas fa-times"></i>
    </div>
        </div>
        <TaskListAdd/>
        <!-- c-task--todo--push -->
        <draggable :list="cards.tasks" tag="div" :options="{animation:300}" >
           <TaskList v-for="(items, index) in cards.tasks" :key="index" :items="items"/>
        </draggable>
      </div>
      <!-- end c-task--todo -->
    </div>
    <!-- end c-task--card__inner -->
    <!-- ここまでTaskCard -->
  </div>
</template>
<script>
import draggable from 'vuedraggable'
import TaskList from './TaskList'
import TaskListAdd from './TaskListAdd'
import TaskCardAdd from './TaskCardAdd'
export default {
  data(){
      return{
     
    }
  },
  props:['cards'],
  components: {
    TaskList,
    TaskListAdd,
    TaskCardAdd,
    draggable
  },
  methods: {
  
  },
}
</script>
<style>

</style>