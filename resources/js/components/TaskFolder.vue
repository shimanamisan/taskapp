<template>
    <div>
      <li class="c-task--folder__wrapp" :class="classObject" @click="setCardLists">
            <i class="fas fa-bars c-task--folder__drag hand-icon"></i>
            <span class="c-task--folder__tips" v-if="editFlag" @dblclick="editFolder" >
              <span class="c-task--folder__item" >{{title_data}}</span> 
            </span>
            <form class="folder--update" @submit.prevent v-else>
              <span class="c-task--folder__tips" >
                <input type="text" class="c-input c-input--tasks" v-model="title_data" @blur="editFolder" @change="test" >
              </span>
            </form>
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
      current_folder_id: '',
      isActiveFolder: false,
      editFlag: true,
      title_data: this.title
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
    classObject(){
      return {
        'u-isActive--folder': this.isActiveFolder
      }
    }
  },
  methods: {
    // フォルダーを削除する
    async deleteFolder(){
      if(window.confirm('フォルダーを削除すると、全てのカード及びタスクリストも削除されます。\nフォルダーを削除しますか？')){
        await this.$store.dispatch('taskStore/deleteFolder', this.id )
      }
    },
    // フォルダーを選択したら、そのフォルダーのカードリストを取得
    async setCardLists(){
      await this.$store.dispatch('taskStore/setCardLists', this.id )
    },
    folderActive(){
      this.isActiveFolder = !this.isActiveFolder
    },
    editFolder(){
      this.editFlag = !this.editFlag
    },
    test(){
      console.log('aaaaaa')
      
    }

  }
}
</script>
<style>
.c-task--folder__trash {
  display: block;
  float: right;
}
.folder--update{
  display: inline-block;
}

.fa-edit{
  margin-right: 5px
}

</style>