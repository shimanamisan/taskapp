<template>
    <div>
      <li class="c-task--folder__wrapp" @click="setCardLists">
            <div class="c-task--dragicon">
              <i class="fas fa-bars hand-icon"></i>
            </div>
              <span class="c-task--folder__item" v-if="!editFlag">{{folderTitle}}</span> 
          
            <form class="c-updateFrom" @submit.prevent v-else>
                <!-- バリデーションエラー --->
                <ul v-if="folderRequestErrorMessages" class="errors errors--tasks">
                <li v-for="(msg, index) in folderRequestErrorMessages.title" :key="index">{{ msg }}</li>
                </ul>
                <!--- end errors -->
              <input type="text" class="c-input c-input--tasks"
              v-model="folderTitle"
              @keypress.enter="updateFolderTitle"
              @keyup.esc="cancelEdit"
              @blur="cancelEdit"
              :class="{'errors--bg': folderRequestErrorMessages}"
              >
            </form>
            <div class="c-task--folder__trash">
              <i class="fas fa-edit c-task--folder--icon" @click="editFolder"></i>
              <i class="fas fa-trash-alt" @click="deleteFolder"></i>
            </div>
        </li>
    </div>
</template>
<script>
import draggable from 'vuedraggable'
import { OK, UNPROCESSABLE_ENTITY, INTERNAL_SERVER_ERROR, CREATED } from '../statusCode'

export default {
  data(){
    return {
      editFlag: false,
      folderTitle: this.title
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
    folderRequestErrorMessages(){
    // エラーメッセージがあった際にストアより取得
    return this.$store.state.taskStore.folderRequestErrorMessages
    },
    getErrorCode(){
      return this.$store.state.error.code
    }
  },
  methods: {
    // フォルダーを削除する
    async deleteFolder(){
      const folder_id = this.id
      if(window.confirm('フォルダーを削除すると、全てのカード及びタスクリストも削除されます。\nフォルダーを削除しますか？')){
        await this.$store.dispatch('taskStore/deleteFolder', folder_id )
      }
    },
    // フォルダーを選択したら、そのフォルダーのカードリストを取得
    async setCardLists(){
      const folder_id = this.id
      await this.$store.dispatch('taskStore/setCardListsAction', folder_id )
    },
    editFolder(){
      this.editFlag = !this.editFlag
      this.clearError()
    },
    cancelEdit(){
      this.editFlag = false
      // キャンセルしたときに、propsで渡ってきている元のデータをdataプロパティに代入する。
      this.folderTitle = this.title
      this.clearError()
    },
    async updateFolderTitle(){
      
      await this.$store.dispatch('taskStore/updateFolderTitle',
      {
        title: this.folderTitle,
        folder_id: this.id
      })

      if(this.getErrorCode === OK){
        this.editFolder()
      }
    },
    /*************************************************
    * バリデーションメッセージを消すアクションを呼ぶ
    **************************************************/
    clearError(){
      this.$store.commit('taskStore/setFolderRequestErrorMessages', null)
    },
  }
}
</script>
<style>
.c-task--folder__trash {
  display: block;
  float: right;
}

.fa-edit{
  margin-right: 5px
}

</style>