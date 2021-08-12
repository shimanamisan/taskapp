<template>
  <div>
    <Loading v-show="this.showLoading" />
    <div
      v-show="!TaskEdit_flg"
      class="c-task__todo--list c-task__todo--push"
      @click="TaskEdit_flg = !TaskEdit_flg"
    >
      ＋ 新しいタスクを追加
    </div>
    <div v-show="TaskEdit_flg" class="c-task__todo__inputAreaWrapp">
      <input
        type="input"
        class="c-task__todo__inputArea"
        :class="{ 'c-error__bg': taskRequestErrorMessages }"
        v-model="TaskCreateForm"
        @keyup.enter="createTask"
        @compositionstart="composing = true"
        @compositionend="composing = false"
      />
      <!-- バリデーションエラー --->
      <ul v-if="taskRequestErrorMessages" class="c-error c-error__tasks">
        <li v-for="(msg, index) in taskRequestErrorMessages.title" :key="index">
          {{ msg }}
        </li>
      </ul>
      <!--- end c-error -->
      <div class="l-flex u-btn__wrapp">
        <div class="u-btn__common__margin">
          <button
            class="c-btn c-btn__common c-btn__common__cancel"
            @click="clearTaskCreateForm"
          >
            キャンセル
          </button>
        </div>
        <div class="u-btn__common__margin">
          <button class="c-btn c-btn__common" @click="createTask">追加</button>
        </div>
      </div>
      <!-- l-flex -->
    </div>
  </div>
</template>
<script>
import {
  OK,
  UNPROCESSABLE_ENTITY,
  INTERNAL_SERVER_ERROR,
  CREATED,
} from "@js/statusCode";
import Loading from "@js/components/Loading";
export default {
  data() {
    return {
      TaskEdit_flg: null,
      TaskCreateForm: "",
      folder_id: this.cards.folder_id,
      card_id: this.cards.id,
      // ローディング画面の表示フラグ
      showLoading: false,
    };
  },
  components: {
    Loading,
  },
  props: {
    cards: {
      type: Object,
      required: true,
    },
  },
  computed: {
    taskRequestErrorMessages() {
      // エラーメッセージがあった際にストアより取得
      return this.$store.state.taskStore.taskRequestErrorMessages;
    },
    getErrorCode() {
      return this.$store.state.error.code;
    },
  },
  methods: {
    // タスクを作成
    async createTask() {
      if (this.composing) {
        // 全角変換処理中なので何も行わない
      } else {
        const title = this.TaskCreateForm;
        const folder_id = this.folder_id;
        const card_id = this.card_id;
        this.isActiveLoading();
        await this.$store.dispatch("taskStore/createTask", {
          // アクションは第2引数までしか引数を受け取れないので、
          // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
          title: title,
          folder_id: folder_id,
          card_id: card_id,
        });

        if (this.getErrorCode === OK) {
          // データが追加されて更新されても、選択されていたフォルダーがそのまま表示されている様に呼び出す
          await this.$store.dispatch(
            "taskStore/setCardListsAction",
            this.folder_id
          );
          this.clearTaskCreateForm();
        } else if (this.getErrorCode === UNPROCESSABLE_ENTITY) {
          // バリデーションエラー時は登録用フォームを非表示にしない
        }
        // 通信が失敗時でも、リストを空にしない
        await this.$store.dispatch("taskStore/setCardListsAction", folder_id);
        this.isActiveLoading();
      }
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
    },
    isActiveLoading() {
      this.showLoading = !this.showLoading;
    },
  },
};
</script>
<style></style>
