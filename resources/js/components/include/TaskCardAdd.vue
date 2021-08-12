<template>
  <div class="c-task__card__wrapp">
    <Loading v-show="this.showLoading" />
    <div
      v-show="!CardEdit_flg"
      class="c-task__todo--list c-task__todo--push"
      @click="CardEdit_flg = !CardEdit_flg"
    >
      ＋ 新しいカードを追加
    </div>
    <div v-show="CardEdit_flg" class="c-task__todo__inputAreaWrapp cardAdd">
      <input
        type="text"
        class="c-task__todo__inputArea"
        :class="{ 'c-error__bg': cardRequestErrorMessages }"
        v-model="CradCreateForm"
        @keydown.enter="createCard"
        @compositionstart="composing = true"
        @compositionend="composing = false"
      />
      <!-- バリデーションエラー --->
      <ul
        v-if="cardRequestErrorMessages"
        class="c-error c-error__tasks c-error__card"
      >
        <p v-for="(msg, index) in cardRequestErrorMessages.title" :key="index">
          {{ msg }}
        </p>
      </ul>
      <!--- end c-error -->
      <div class="l-flex u-btn__wrapp">
        <div class="u-btn__common__margin">
          <button
            class="c-btn c-btn__common c-btn__common__cancel"
            @click="clearCradCreateForm"
          >
            キャンセル
          </button>
        </div>
        <div class="u-btn__common__margin">
          <button type="submit" class="c-btn c-btn__common" @click="createCard">
            追加
          </button>
        </div>
      </div>
      <!-- l-flex -->
    </div>
    <!-- c-task__todo__inputAreaWrapp -->
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
      CardEdit_flg: false,
      CradCreateForm: "",
      folder_id: "",
      // ローディング画面の表示フラグ
      showLoading: false,
    };
  },
  components: {
    Loading,
  },
  computed: {
    cardRequestErrorMessages() {
      // エラーメッセージがあった際にストアより取得
      return this.$store.state.taskStore.cardRequestErrorMessages;
    },
    getErrorCode() {
      return this.$store.state.error.code;
    },
  },
  methods: {
    // 投稿の内容をアクションへ渡す
    async createCard() {
      if (this.composing) {
        // 全角変換処理中なので何も行わない
      } else {
        this.isActiveLoading();
        // this.$store.commit("taskStore/setCardRequestErrorMessages", null);
        // ストアからフォルダーIDを呼び出す
        this.folder_id = this.$store.state.taskStore.folder_id;
        if (!this.folder_id) {
          const errorMsg = {
            title: ["フォルダーを選択してタスクを登録してください"],
          };
          this.$store.commit("taskStore/setCardRequestErrorMessages", errorMsg);
          this.isActiveLoading();
          return false;
        }
        // 呼び出したフォルダーIDをフォームの内容をアクションへ渡す
        await this.$store.dispatch("taskStore/createCard", {
          // アクションは第2引数までしか引数を受け取れないので、
          // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
          title: this.CradCreateForm,
          folder_id: this.folder_id,
        });

        console.log("enter!");

        if (this.getErrorCode === OK) {
          await this.$store.dispatch(
            "taskStore/setCardListsAction",
            this.folder_id
          );
          this.clearCradCreateForm();
        } else if (this.getErrorCode === UNPROCESSABLE_ENTITY) {
          // バリデーションエラー時は登録用フォームを非表示にしない
        }
        // 通信が失敗時でも、リストを空にしない
        await this.$store.dispatch(
          "taskStore/setCardListsAction",
          this.folder_id
        );
        this.isActiveLoading();
      }
    },
    // 投稿後にフォームの中身を削除し、フォームを非表示にする
    clearCradCreateForm() {
      this.CradCreateForm = "";
      this.showCreateCardFrom();
      this.clearError();
    },
    /*************************************************
     * タスク追加用フォームの表示
     **************************************************/
    showCreateCardFrom() {
      this.CardEdit_flg = !this.CardEdit_flg;
    },
    /*************************************************
     * バリデーションメッセージを消すアクションを呼ぶ
     **************************************************/
    clearError() {
      this.$store.commit("taskStore/setCardRequestErrorMessages", null);
    },
    isActiveLoading() {
      this.showLoading = !this.showLoading;
    },
  },
};
</script>
<style></style>
