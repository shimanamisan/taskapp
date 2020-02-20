<template>
    <div>
        <div v-show="!TaskEdit_flg" class="c-task--todo--list c-task--todo--push" @click="TaskEdit_flg = !TaskEdit_flg">＋ 新しいタスクを追加 </div>
        <div v-show="TaskEdit_flg" class="c-task--todo--inputAreaWrapp">
            <form @submit.prevent>
                <input type="input" class="c-task--todo--inputArea" v-model="TaskCreateForm">
                <div class="l-flex u-btn--wrapp">
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearTaskCreateForm">キャンセル</button>
                    </div>
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile" @click="createTask">追加</button>
                    </div>
                </div>
                <!-- l-flex -->
            </form>
        </div>
    </div>
</template>
<script>
export default {
  data(){
    return{
      TaskEdit_flg: null,
      TaskCreateForm: '',
    }
  },
  props: {
    cards: {
      type: Object,
      required: true
    }
  },
  methods:{
    // 投稿の内容をアクションへ渡す
    async createTask(){
      // 呼び出したフォルダーIDをフォームの内容をアクションへ渡す
      await this.$store.dispatch('taskStore/createTask',
      { 
        // アクションは第2引数までしか引数を受け取れないので、
        // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
        title: this.TaskCreateForm,
        folder_id: this.cards.folder_id,
        card_id: this.cards.id
      })

      this.clearTaskCreateForm()
    },
    clearTaskCreateForm(){
      this.TaskCreateForm = ''
      this.TaskEdit_flg = !this.TaskEdit_flg
    }
  }
}
</script>
<style>

</style>