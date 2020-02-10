<template>
    <div>
        <!-- ここからTaskList -->
        <div class="c-task--card">
            <div class="c-task--card__inner">
                <div class="c-task--todo">
                    <div class="c-task--todo__header">タスクタイトル 
                        <label for="" class="c-task--todo--counter">0</label>
                    </div>
                    <TaskListAdd/>
                    <!-- c-task--todo--push -->
                    <div class="c-task--todo__card">
                        <div class="c-task--todo--list">TODOリスト 
                            <div class="c-task--todo--list--del">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <div class="c-task--todo--list">TODOリスト 
                            <div class="c-task--todo--list--del">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                        <div class="c-task--todo--list">TODOリスト 
                            <div class="c-task--todo--list--del">
                                <i class="fas fa-times"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end c-task--todo -->
            </div>
            <!-- end c-task--card__inner -->
            <CardAdd/>
        </div>
        <!-- ここまでTaskList -->
    </div>
</template>
<script>
import TaskListAdd from './TaskListAdd'
import CardAdd from './CardAdd'
export default {
  data(){
      return{
     
      }
  },
  components: {
    TaskListAdd,
    CardAdd
  },
  methods: {
  
  },
}
</script>
<style>

</style>