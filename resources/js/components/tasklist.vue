<template>
  <div class="c-task--todo--list">
    {{title}}
    <div class="c-task--todo--list--del"  @dbclick="deleteTask">
      <i class="fas fa-times"></i>
    </div>
  </div>
</template>

<script>

export default {
  data(){
    return {
      folder_id: this.cards.folder_id,
      card_id: this.cards.id
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
        await this.$store.dispatch('taskStore/deleteTask', this.id)}
    }
  }
}
</script>

<style>

</style>