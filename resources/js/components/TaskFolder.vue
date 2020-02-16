<template>
    <div>
      <li class="c-task--folder__wrapp" @click="setCardLists">
            <i class="fas fa-bars c-task--folder__drag hand-icon"></i>
            <label class="c-task--folder__item" for="">{{title}}</label>
            <div class="c-task--folder__trash">
               <i class="fas fa-trash-alt" @click="deleteFolder"></i>
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
    title: {
      type: String,
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
  computed: {

  },
  methods: {
    // フォルダーを削除する
    async deleteFolder(){
      if(window.confirm('フォルダーを削除すると全てのタスクも削除されます。\nフォルダーを削除しますか？')){
        await this.$store.dispatch('taskStore/deleteFolder', this.id )
      }
    },
    // フォルダーを選択したら、そのフォルダーのカードリストを取得
    async setCardLists(){
      await this.$store.dispatch('taskStore/setCardLists', this.id )
    }
  }
}
</script>
<style>
.c-task--folder__trash {
  display: block;
  float: right;
}

</style>