<template>
  <div>
    <Loading v-show="this.showLoading" />
    <div
      v-show="!folderEdit_flg"
      class="c-task__todo--list c-task__todo--push"
      @click="folderEdit_flg = !folderEdit_flg"
    >
      ＋ 新しいフォルダを追加
    </div>
    <div v-show="folderEdit_flg" class="c-task__todo__inputAreaWrapp">
      <input
        type="text"
        class="c-task__todo__inputArea"
        :class="{ 'c-error__bg': folderRequestErrorMessages }"
        v-model="folderTitle"
        @keydown.enter="createFolder"
        @compositionstart="composing = true"
        @compositionend="composing = false"
      />
      <!-- バリデーションエラー --->
      <ul v-if="folderRequestErrorMessages" class="c-error c-error__tasks">
        <li
          v-for="(msg, index) in folderRequestErrorMessages.title"
          :key="index"
        >
          {{ msg }}
        </li>
      </ul>
      <!--- end c-error -->
      <div class="l-flex u-btn__wrapp">
        <div class="u-btn__common__margin">
          <button
            class="c-btn c-btn__common c-btn__common__cancel"
            @click="clearFolderCreateForm"
          >
            キャンセル
          </button>
        </div>
        <div class="u-btn__common__margin">
          <button
            type="submit"
            class="c-btn c-btn__common"
            @click="createFolder"
          >
            追加
          </button>
        </div>
      </div>
      <!-- end l-flex -->
    </div>
    <!-- ebd c-task__todo--push -->
  </div>
</template>
<script>
import {
  OK,
  UNPROCESSABLE_ENTITY,
  INTERNAL_SERVER_ERROR,
  CREATED,
} from "@js/statusCode";
import { mapState, mapGetters } from "vuex";
import Loading from "@js/components/Loading";
export default {
  data() {
    return {
      folderEdit_flg: null,
      folderTitle: "",
      // ローディング画面の表示フラグ
      showLoading: false,
    };
  },
  components: {
    Loading,
  },
  props: {
    list: {
      type: Array,
      required: true,
    },
  },
  computed: {
    ...mapState({
      folderRequestErrorMessages: (state) =>
        state.taskStore.folderRequestErrorMessages,
    }),
    ...mapGetters({
      getCode: "error/getCode",
    }),
    // mapStateなどをを使わない書き方
    // folderRequestErrorMessages(){
    // // エラーメッセージがあった際にストアより取得
    // return this.$store.state.taskStore.folderRequestErrorMessages
    // },
    // getErrorCode(){
    //   return this.$store.state.error.code
    // }
  },
  methods: {
    async createFolder() {
      if (this.composing) {
        // 全角変換処理中なので何も行わない
      } else {
        this.isActiveLoading();
        await this.$store.dispatch("taskStore/createFolder", {
          title: this.folderTitle,
        });
        if (this.getCode === 200) {
          this.clearFolderCreateForm();
        } else if (this.getCode === UNPROCESSABLE_ENTITY) {
          // バリデーションエラー時は登録用フォームを非表示にしない
        }
        this.isActiveLoading();
      }
    },
    clearFolderCreateForm() {
      this.folderTitle = "";
      this.folderEdit_flg = !this.folderEdit_flg;
      this.clearError();
    },
    /*************************************************
     * バリデーションメッセージを消すアクションを呼ぶ
     **************************************************/
    clearError() {
      this.$store.commit("taskStore/setFolderRequestErrorMessages", null);
    },
    isActiveLoading() {
      this.showLoading = !this.showLoading;
    },
  },
};
</script>
<style></style>
