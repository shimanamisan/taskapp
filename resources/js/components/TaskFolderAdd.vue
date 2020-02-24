<template>
    <div>
        <div v-show="!folderEdit_flg" class="c-task--todo--list c-task--todo--push" @click="folderEdit_flg = !folderEdit_flg">＋ 新しいフォルダを追加 </div>
        <div v-show="folderEdit_flg" class="c-task--todo--inputAreaWrapp">
            <form @submit.prevent>
                <input type="input" class="c-task--todo--inputArea" :class="{'errors--bg': folderRequestErrorMessages}" v-model="folderTitle">
                <!-- バリデーションエラー --->
                <ul v-if="folderRequestErrorMessages" class="errors errors--tasks">
                    <li v-for="(msg, index) in folderRequestErrorMessages.title" :key="index">{{ msg }}</li>
                </ul>
                <!--- end errors -->
                <div class="l-flex u-btn--wrapp">
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearFolderCreateForm">キャンセル</button>
                    </div>
                    <div class="u-btn__profile--margin">
                        <button type="submit" class="c-btn c-btn--profile" @click="createFolder">追加</button>
                    </div>
                </div>
                <!-- end l-flex -->
            </form>
        </div>
        <!-- ebd c-task--todo--push -->
    </div>
</template>
<script>
export default {
  data(){
    return{
      folderEdit_flg: null,
      folderTitle: '',
    }
  },
  props: {
    list: {
      type: Array,
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
    async createFolder(){
      await this.$store.dispatch('taskStore/createFolder', { title: this.folderTitle })

      if(this.getErrorCode === 200){
        this.clearFolderCreateForm()
      }
    },
    clearFolderCreateForm(){
    this.folderTitle = ''
    this.folderEdit_flg = !this.folderEdit_flg
    this.clearError()
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

</style>