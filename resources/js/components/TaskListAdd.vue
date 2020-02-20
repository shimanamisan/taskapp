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
    list: {
      type: Object,
      required: true
    }
  },
  methods:{
    // タスクを作成
    async createTask(){
      await this.$store.dispatch('taskStore/createTask',
      { 
        // アクションは第2引数までしか引数を受け取れないので、
        // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
        title: this.TaskCreateForm,
        folder_id: this.list.folder_id,
        card_id: this.list.id
      })

      // 削除後更新されるので、選択されていたものがそのまま表示されている様に呼び出す
      await this.$store.dispatch('taskStore/setCardLists', this.list.folder_id )

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