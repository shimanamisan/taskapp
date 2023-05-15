<template>
  <div>
    <Loading v-show="this.showLoading" />
    <li
      class="c-task__folder__wrapp"
      :class="currentFolder(this.id)"
      @click="setCardLists"
    >
      <div class="c-task__dragicon">
        <i class="fas fa-bars u-handle"></i>
      </div>
      <span class="c-task__folder__item" v-if="!editFlag">{{
        folderTitle
      }}</span>

      <div class="c-updateFrom" v-else>
        <input
          type="text"
          class="c-input c-input__tasks"
          v-model="folderTitle"
          @keypress.enter="updateFolderTitle"
          @compositionstart="composing = true"
          @compositionend="composing = false"
          @blur="updateFolderTitle"
          @keyup.esc="cancelEdit"
          :class="{ 'c-error__bg': folderRequestErrorMessages }"
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
        <!--- end errors -->
      </div>
      <div class="c-task__folder__trash">
        <i class="fas fa-edit c-task__folder--icon" @click="editFolder"></i>
        <i class="fas fa-trash-alt" @click="deleteFolder"></i>
      </div>
    </li>
  </div>
</template>
<script>
import { mapState, mapGetters } from "vuex";
import { OK } from "@js/statusCode";
import draggable from "vuedraggable";
import Loading from "@js/components/Loading";

export default {
  data() {
    return {
      editFlag: false,
      folderTitle: this.title,
      folderActive: "c-task__folder__wrapp--active",
      folderDisable: "",
      // ローディング画面の表示フラグ
      showLoading: false,
    };
  },
  components: {
    draggable,
    Loading,
  },
  props: {
    title: {
      type: String,
      required: true,
    },
    id: {
      type: Number,
      required: true,
    },
    listIndex: {
      type: Number,
      required: true,
    },
  },
  computed: {
    ...mapState({
      // エラーメッセージがあった際にストアより取得
      folderRequestErrorMessages: (state) =>
        state.taskStore.folderRequestErrorMessages,
    }),
    ...mapGetters({
      getCode: "error/getCode",
      current_folderId: "taskStore/current_folderId",
    }),
  },
  methods: {
    // フォルダーを選択したら、そのフォルダーのカードリストをセットする
    async setCardLists() {
      const folder_id = this.id;
      // クリックしたフォルダーのIDとVuexに格納されている現在のフォルダーIDが
      // 違った場合にDBへフォルダー配下のタスクデータを取得しに行く
      if (folder_id !== this.current_folderId) {
        this.isActiveLoading();
        await this.$store.dispatch("taskStore/setCardListsAction", folder_id);
        this.isActiveLoading();
      }
    },
    // フォルダーのタイトルを更新する
    async updateFolderTitle() {
      if (this.composing) {
        // 全角変換処理中なので何も行わない
      } else {
        this.isActiveLoading();
        await this.$store.dispatch("taskStore/updateFolderTitle", {
          title: this.folderTitle,
          folder_id: this.id,
        });
        if (this.getCode === OK) {
          this.editFlag = false;
          this.clearError();
        }
        this.isActiveLoading();
      }
    },
    compstart() {
      console.log("変換スタート");
    },
    compend() {
      console.log("変換終了");
    },
    // フォルダーを削除する
    async deleteFolder() {
      const folder_id = this.id;
      if (
        window.confirm(
          "フォルダーを削除すると、全てのカード及びタスクリストも削除されます。\nフォルダーを削除しますか？"
        )
      ) {
        await this.$store.dispatch("taskStore/deleteFolder", folder_id);
      }
    },
    // 選択されているフォルダーに背景色のクラスをつけるための判定を行う
    currentFolder(folder_id) {
      if (folder_id === this.current_folderId) {
        return this.folderActive;
      } else {
        return this.folderDisable;
      }
    },
    // 更新用のフォームを呼び出す
    editFolder() {
      this.editFlag = !this.editFlag;
      this.clearError();
    },
    // 更新フォームがキャンセルされたとき
    cancelEdit() {
      this.editFlag = false;
      // キャンセルしたときに、propsで渡ってきている元のデータをdataプロパティに代入する。
      this.folderTitle = this.title;
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
