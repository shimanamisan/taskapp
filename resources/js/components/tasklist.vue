<template>
  <div class="c-task--todo--list">
    <span class="c-task--todo--tips">{{title}}</span>
     <div class="c-task--todo--list--del" @click="deleteTask">
      <i class="fas fa-times"></i>
    </div>
    <i class="far fa-clock">
      <span class="c-task--todo--clock">{{created_at}}</span>
    </i>
   
  </div>
</template>

<script>

export default {
  data(){
    return {
      folder_id: this.cards.folder_id,
      card_id: this.cards.id,
      task_id: this.id
    }
  },
  props: {
    title: {
      type: String,
    },
    status: {
      type: String
    },
    id: {
      type: Number,
      required: true
    },
    listIndex: {
      type: Number,
      required: true
    },
    created_at: {
      type: String,
      required: true
    },
    cards: {
      type: Object,
      required: true
    }
  },
  computed:{
    
  },
  methods:{
    async deleteTask(){
       if(window.confirm('タスクを削除しますか？')){
          const folder_id = this.folder_id
          const card_id = this.card_id
          const task_id = this.task_id
          await this.$store.dispatch('taskStore/deleteTask',
         {
           folder_id: folder_id,
           card_id: card_id,
           task_id: task_id
         })
          // 削除後データが更新されるので、選択されていたフォルダーを保持するための処理
          await this.$store.dispatch('taskStore/setCardListsAction', folder_id )
        }
    },
  }
}
</script>

<style>
.fa-clock{
display: block; 
font-size: 12px;
}
.c-task--todo--clock{
  margin-left: 5px
}
</style>