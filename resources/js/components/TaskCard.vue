<template>
    <div>
        <!-- ここからTaskList -->
        <div class="c-task--card__inner">
            <div class="c-task--todo">
                <div class="c-task--todo__header">
                    <span v-if="!editFlag" @dblclick="editCard">{{ cardTitle }} </span>
                    <form class="c-updateFrom" @submit.prevent v-else>
                        <!-- バリデーションエラー --->
                        <ul v-if="cardRequestErrorMessages" class="errors errors--tasks">
                            <li v-for="(msg, index) in cardRequestErrorMessages.title" :key="index">{{ msg }} </li>
                        </ul>
                        <!--- end errors -->
                        <input type="text" class="c-input c-input--tasks"
                        v-model="cardTitle"
                        @keypress.enter="updateCardTitle"
                        @keyup.esc="cancelEdit"
                        @blur="cancelEdit"
                        :class="{'errors--bg': cardRequestErrorMessages}"
                        >
                    </form>
                    <label for="" class="c-task--todo--counter">{{ listCounter }} </label>
                    <div class="c-task--todo--card--del">
                        <i class="fas fa-times" @click="deleteCard"></i>
                    </div>
                </div>
                <TaskListAdd :cards="cards"/>
                <!-- c-task--todo--push -->
                <draggable :list="cards.tasks" tag="div" v-bind="{group :'cards.tasks', animation: 300}">
                    <TaskList v-for="(task, index) in cards.tasks" :key="task.id" :id="task.id" :title="task.title" :listIndex="index" :created_at="task.created_at" :cards = "cards" />
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
  data() {
      return {
        editFlag: false,
        cardTitle: this.cards.title
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
    },
    cardRequestErrorMessages(){
    // エラーメッセージがあった際にストアより取得
    return this.$store.state.taskStore.cardRequestErrorMessages
    },
    getErrorCode(){
      return this.$store.state.error.code
    }
  },
  methods: {
    async deleteCard(){
      const folder_id = this.cards.folder_id
      const card_id = this.cards.id
      // console.log( 'これはカードid：' + folder_id + '  ' + 'これはフォルダid：' + card_id)
      if(window.confirm('カードを削除すると、全てのタスクリストも削除されます。nフォルダーを削除しますか？')){
        await this.$store.dispatch('taskStore/deleteCard', 
        {
          folder_id: folder_id,
          card_id: card_id
        })

        // 削除後データが更新されるので、選択されていたフォルダーを保持するための処理
        await this.$store.dispatch('taskStore/setCardListsAction', folder_id )
      }
    },
    async updateCardTitle(){
      const folder_id = this.cards.folder_id
      const card_id = this.cards.id
      await this.$store.dispatch('taskStore/updateCardTitle',
      {
        title: this.cardTitle,
        folder_id: folder_id,
        card_id: card_id
      })
      await this.$store.dispatch('taskStore/setCardListsAction', folder_id )

      if(this.getErrorCode === 200){
        this.editCard()
      // 更新後データが更新されるので、選択されていたフォルダーを保持するための処理
        
      }
    },
     editCard(){
      this.editFlag = !this.editFlag
      this.clearError()
    },
    cancelEdit(){
      this.editFlag = false
      // キャンセルしたときに、propsで渡ってきている元のデータをdataプロパティに代入する。
      this.cardTitle = this.cards.title
      this.clearError()
    },
    /*************************************************
    * バリデーションメッセージを消すアクションを呼ぶ
    **************************************************/
    clearError(){
      this.$store.commit('taskStore/setCardRequestErrorMessages', null)
    },
  },
}
</script>
<style>

</style>