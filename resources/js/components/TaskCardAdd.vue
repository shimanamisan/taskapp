<template>
    <div class="v-div">
        <div v-show="!CardEdit_flg" class="c-task--todo--list c-task--todo--push" @click="CardEdit_flg = !CardEdit_flg">＋ 新しいカードを追加 </div>
        <div v-show="CardEdit_flg" class="c-task--todo--inputAreaWrapp CardAdd">
            <form @submit.prevent>
                <input type="input" class="c-task--todo--inputArea" v-model="CradCreateForm">
                <div class="l-flex u-btn--wrapp">
                    <!-- バリデーションエラー --->
                    <div v-if="requestErrorMessages" class="errors">
                        <ul v-if="requestErrorMessages">
                            <li v-for="msg in requestErrorMessages" :key="msg">{{ msg }}</li>
                        </ul>
                    </div>
                    <!--- end errors -->
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearCradCreateForm">キャンセル</button>
                    </div>
                    <div class="u-btn__profile--margin">
                        <button type="submit" class="c-btn c-btn--profile" @click="createCard">追加</button>
                    </div>
                </div>
                <!-- l-flex -->
            </form>
        </div>
        <!-- c-task--todo--inputAreaWrapp -->
    </div>
</template>
<script>
export default {
  data(){
    return{
      CardEdit_flg: null,
      CradCreateForm: '',
      folder_id: ''
    }
  },
  computed: {
    requestErrorMessages(){
    // エラーメッセージがあった際にストアより取得
    return this.$store.state.taskStore.requestErrorMessages
    },
    getErrorCode(){
      return this.$store.state.error.code
    }
  },
  methods: {
    // 投稿の内容をアクションへ渡す
    async createCard(){
      // ストアからフォルダーIDを呼び出す
      this.folder_id = this.$store.state.taskStore.folder_id
      // 呼び出したフォルダーIDをフォームの内容をアクションへ渡す
      await this.$store.dispatch('taskStore/createCard',
      { 
        // アクションは第2引数までしか引数を受け取れないので、
        // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
        title: this.CradCreateForm,
        folder_id: this.folder_id
      })

      this.clearCradCreateForm()
    },
    // 投稿後にフォームの中身を削除し、フォームを非表示にする
    clearCradCreateForm(){
    this.CradCreateForm = ''
    this.CardEdit_flg = !this.CardEdit_flg
    }
  }
}
</script>
<style>
.v-div{
  padding: 0 20px;
}
.CardAdd{
  padding: 0 20px 0 0;
}
</style>