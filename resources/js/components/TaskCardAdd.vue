<template>
  <div class="v-div">
    <div
      v-show="!CardEdit_flg"
      class="c-task--todo--list c-task--todo--push"
      @click="CardEdit_flg = !CardEdit_flg"
    >＋ 新しいカードを追加</div>
    <div v-show="CardEdit_flg" class="c-task--todo--inputAreaWrapp cardAdd">
      <form @submit.prevent>
        <input
          type="text"
          class="c-task--todo--inputArea"
          :class="{'errors--bg': cardRequestErrorMessages}"
          v-model="CradCreateForm"
        />
        <!-- バリデーションエラー --->
        <ul v-if="cardRequestErrorMessages" class="errors errors--tasks">
          <p v-for="(msg, index) in cardRequestErrorMessages.title" :key="index">{{ msg }}</p>
        </ul>
        <!--- end errors -->
        <div class="l-flex u-btn--wrapp">
          <div class="u-btn__profile--margin">
            <button
              class="c-btn c-btn--profile c-btn--profile__cancel"
              @click="clearCradCreateForm"
            >キャンセル</button>
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
import {
  OK,
  UNPROCESSABLE_ENTITY,
  INTERNAL_SERVER_ERROR,
  CREATED
} from "../statusCode";

export default {
  data() {
    return {
      CardEdit_flg: null,
      CradCreateForm: "",
      folder_id: ""
    };
  },
  computed: {
    cardRequestErrorMessages() {
      // エラーメッセージがあった際にストアより取得
      return this.$store.state.taskStore.cardRequestErrorMessages;
    },
    getErrorCode() {
      return this.$store.state.error.code;
    }
  },
  methods: {
    // 投稿の内容をアクションへ渡す
    async createCard() {
      this.$store.commit("taskStore/setCardRequestErrorMessages", null);
      // ストアからフォルダーIDを呼び出す
      this.folder_id = this.$store.state.taskStore.folder_id;
      if (!this.folder_id) {
        const data = {
          title: ["フォルダーを選択してタスクを登録してください"]
        };
        this.$store.commit("taskStore/setCardRequestErrorMessages", data);
        return false;
      }

      // 呼び出したフォルダーIDをフォームの内容をアクションへ渡す
      await this.$store.dispatch("taskStore/createCard", {
        // アクションは第2引数までしか引数を受け取れないので、
        // 複数のデータをアクションへ渡すには、オブジェクト形式で渡す。
        title: this.CradCreateForm,
        folder_id: this.folder_id
      });

      if (this.getErrorCode === OK) {
        await this.$store.dispatch(
          "taskStore/setCardListsAction",
          this.folder_id
        );
        this.clearCradCreateForm();
      }
      // 通信が失敗時でも、リストを空にしない
      await this.$store.dispatch(
        "taskStore/setCardListsAction",
        this.folder_id
      );
    },
    // 投稿後にフォームの中身を削除し、フォームを非表示にする
    clearCradCreateForm() {
      this.CradCreateForm = "";
      this.CardEdit_flg = !this.CardEdit_flg;
      this.clearError();
    },
    /*************************************************
     * バリデーションメッセージを消すアクションを呼ぶ
     **************************************************/
    clearError() {
      this.$store.commit("taskStore/setCardRequestErrorMessages", null);
    }
  }
};
</script>
<style>
.v-div {
  padding: 0 20px;
  max-width: 220px;
}
.cardAdd {
  padding: 0 20px 0 0;
}
</style>