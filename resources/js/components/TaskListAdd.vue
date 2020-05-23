<template>
  <div>
    <div
      v-show="!TaskEdit_flg"
      class="c-task--todo--list c-task--todo--push"
      @click="TaskEdit_flg = !TaskEdit_flg"
    >＋ 新しいタスクを追加</div>
    <div v-show="TaskEdit_flg" class="c-task--todo--inputAreaWrapp">
      <form @submit.prevent>
        <input
          type="input"
          class="c-task--todo--inputArea"
          :class="{'errors--bg': taskRequestErrorMessages}"
          v-model="TaskCreateForm"
        />
        <!-- バリデーションエラー --->
        <ul v-if="taskRequestErrorMessages" class="errors errors--tasks">
          <li v-for="(msg, index) in taskRequestErrorMessages.title" :key="index">{{ msg }}</li>
        </ul>
        <!--- end errors -->
        <div class="l-flex u-btn--wrapp">
          <div class="u-btn__profile--margin">
            <button
              class="c-btn c-btn--profile c-btn--profile__cancel"
              @click="clearTaskCreateForm"
            >キャンセル</button>
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
  data() {
    return {
      TaskEdit_flg: null,
      TaskCreateForm: "",
      folder_id: this.cards.folder_id,
      card_id: this.cards.id
    };
  },
  props: {
    cards: {
      type: Object,
      required: true
    }
  },
  computed: {
    taskRequestErrorMessages() {
      // エラーメッセージがあった際にストアより取得
      return this.$store.state.taskStore.taskRequestErrorMessages;
    },
    getErrorCode() {
      return this.$store.state.error.code;
    }
  },
  methods: {
    // タスクを作成
    async createTask() {
      const title = this.TaskCreateForm;
      const folder_id = this.folder_id;
      const card_id = this.card_id;
      await this.$store.dispatch("taskStore/createTask", {
        // アクションは第2引数までしか引数を受け取れないので、
        // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
        title: title,
        folder_id: folder_id,
        card_id: card_id
      });

      if (this.getErrorCode === 200) {
        // データが追加されて更新されても、選択されていたフォルダーがそのまま表示されている様に呼び出す
        await this.$store.dispatch(
          "taskStore/setCardListsAction",
          this.folder_id
        );
        this.clearTaskCreateForm();
      }
      // 通信が失敗時でも、リストを空にしない
      await this.$store.dispatch("taskStore/setCardListsAction", folder_id);
    },
    // タスク登録後、フォームの内容を空にして非表示にする
    clearTaskCreateForm() {
      this.TaskCreateForm = "";
      this.TaskEdit_flg = !this.TaskEdit_flg;
      this.clearError();
    },
    /*************************************************
     * バリデーションメッセージを消すアクションを呼ぶ
     **************************************************/
    clearError() {
      this.$store.commit("taskStore/setTaskRequestErrorMessages", null);
    }
  }
};
</script>
<style>
</style>