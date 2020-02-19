<template>
  <div>
    <!-- ここからTaskList -->
    
    <div class="c-task--card__inner">
      <div class="c-task--todo">
        <div class="c-task--todo__header">{{ cards.title }}
          <label for="" class="c-task--todo--counter">{{ listCounter }}</label>
            <div class="c-task--todo--list--del">
               <i class="fas fa-times" @click="deleteCard"></i>
            </div>
        </div>
        <TaskListAdd/>
        <!-- c-task--todo--push -->
        <draggable :list="cards.tasks" tag="div" v-bind="{animation:300}" group="cards">
           <TaskList v-for="(task, index) in cards.tasks"
           :key = "task.id"
           :id = "task.id"
           :task = "task"
           :listIndex = "index"
           />
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
        // listCounter()メソッドで使うデータプロパティ
        data: this.cards,
    }
  },
  props: {
    cards: {
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
  components: {
    TaskList,
    TaskListAdd,
    TaskCardAdd,
    draggable
  },
  computed:{
    listCounter(){
      return this.cards.tasks.length
    }  
  },
  methods: {
    async deleteCard(){
      const folder_id = this.cards.folder_id
      const card_id = this.cards.id
      // console.log( 'これはカードid：' + folder_id + '  ' + 'これはフォルダid：' + card_id)
      if(window.confirm('フォルダーを削除すると全てのタスクも削除されます。\nフォルダーを削除しますか？')){
        await this.$store.dispatch('taskStore/deleteCard', 
        {
          folderId: folder_id,
          cardId: card_id
        })

        // 削除後更新されるので、選択されていたものがそのまま表示されている様に呼び出す
        await this.$store.dispatch('taskStore/setCardLists', folder_id )
      }
    }
  },
}
</script>
<style>

</style>