<template>
  <div>
    <Header />
    <div class="c-task">
      <div class="c-task--content">
        <div class="c-task--borad01">
          <div class="c-task--borad02">
            <div class="c-task--borad03">
              <div class="c-task__sidebar">
                <TaskFolderProfile />
                <hr class="u-task-line" />
                <TaskFolderAdd :list="FolderLists" />
                <div
                  class="c-task__sidebar__folder c-task__folder"
                  id="folder_height"
                >
                  <!-- Edgeでソート出来ない場合に :forceFallback="true" を記述 -->
                  <draggable
                    :forceFallback="true"
                    :list="FolderLists"
                    tag="ul"
                    v-bind="getOptionsForFolder()"
                    handle=".u-handle"
                    @change="onFolderChange"
                  >
                    <TaskFolder
                      v-for="(folders, index) in FolderLists"
                      :key="folders.id"
                      :id="folders.id"
                      :listIndex="index"
                      :title="folders.title"
                    />
                  </draggable>
                </div>
                <!-- end c-task__sidebar__folder -->
              </div>
              <!-- end c-task__sidebar -->

              <!-- TODOコンポーネント  -->
              <div class="u-activeMSG" v-if="this.current_folderId === ''">
                <p>フォルダーを選択して下さい</p>
              </div>

              <draggable
                v-else
                tag="ul"
                class="c-task__card"
                :forceFallback="true"
                :list="CardLists"
                v-bind="getOptionsForFolder()"
                handle=".u-handle"
                @change="onCradChange"
              >
                <TaskCard
                  v-for="(cards, index) in CardLists"
                  :key="cards.id"
                  :id="cards.id"
                  :listIndex="index"
                  :cards="cards"
                />
              </draggable>

              <TaskCardAdd :class="{ 'u-velse': !this.current_folderId }" />
            </div>
            <!-- end c-task--borad03 -->
          </div>
          <!-- end c-task--borad02 -->
        </div>
        <!-- end c-task--borad01 -->
      </div>
      <!-- end c-task-content -->
    </div>
  </div>
</template>
<script>
import draggable from "vuedraggable";
import { mapState, mapGetters } from "vuex";
import Header from "@js/components/include/Header";
import TaskFolderProfile from "@js/components/include/TaskFolderProfile";
import TaskFolderAdd from "@js/components/include/TaskFolderAdd";
import TaskFolder from "@js/components/TaskFolder";
import TaskCard from "@js/components/TaskCard";
import TaskCardAdd from "@js/components/include/TaskCardAdd";
import Message from "@js/components/include/Message";

export default {
  data() {
    return {
      // folderData: ''
    };
  },
  components: {
    Header,
    TaskFolderProfile,
    TaskFolderAdd,
    TaskFolder,
    TaskCard,
    TaskCardAdd,
    draggable,
    Message,
  },
  computed: {
    // taskStore.jsのステート：FolderListsを常に参照している
    ...mapState({
      FolderLists: (state) => state.taskStore.FolderLists,
      CardLists: (state) => state.taskStore.CardLists,
    }),
    ...mapGetters({
      current_folderId: "taskStore/current_folderId",
    }),
  },
  methods: {
    // vue-draggableオプションをメソッドに切り出し
    getOptionsForFolder() {
      return { animation: 500, delay: 50 };
    },
    getOptionsForCrad() {
      return { animation: 500, delay: 50 };
    },
    async setFolderLists(data) {
      await this.$store.dispatch("taskStore/setFolderLists", data);
    },
    async getFolderLists() {
      await axios
        .get("/api/folder")
        .then((response) => {
          var data = response.data.folders;
          // this.folderData = data
          this.setFolderLists(data);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    // フォルダのソート機能
    async updateFolderSort(newFolders) {
      await this.$store.dispatch("taskStore/updateFolderSort", newFolders);
    },
    // vue-draggableをLaravelと連携するメソッド
    onFolderChange() {
      // 順番が入れ替わった際に、現在のpriorityに1を足すことで入れ替わったリストの情報をLaravel側に通知する
      let newFolders = this.FolderLists.map((folder, index) => {
        folder.priority = index + 1;
        return folder;
      });
      this.updateFolderSort(newFolders);
    },
    // カードのソート機能
    async updateCardSort(newCrads) {
      await this.$store.dispatch("taskStore/updateCardSort", {
        newCrads,
      });
    },
    // draggableコンポーネントからchangeイベントを拾って処理を行う
    onCradChange() {
      // ストア内のカードリストを参照し、priorityプロパティを更新する
      let newCrads = this.CardLists.map((card, index) => {
        card.priority = index + 1;
        return card;
      });
      // アクションへディスパッチするメソッドを呼ぶ
      this.updateCardSort(newCrads);
    },
    setStyleFolserHeight() {
      let phoneActive = /iPhone|iPod|iPad|Android/i.test(
        window.navigator.userAgent
      );

      console.log(phoneActive);

      // ブラウザの画面内の高さを収録
      const inner = window.innerHeight;
      console.log("window.innerHeight :" + inner);
      const targetEl = document.getElementById("folder_height");
      // getBoundingClientRect()：スタイルにサイズが設定されていない状態で要素の幅や高さを取得する
      const targetEl_Top = targetEl.getBoundingClientRect().top;
      const targetEl_Height = targetEl.getBoundingClientRect().height;
      const custumHeight = targetEl_Top + targetEl_Height;
      const paddingSum = 20;
      console.log("height: " + targetEl.getBoundingClientRect().height);
      console.log("top: " + targetEl.getBoundingClientRect().top);
      console.log(
        "targetEl_Top + targetEl_Height: " +
          targetEl_Top +
          " + " +
          targetEl_Height
      );
      console.log("custumHeight: " + custumHeight);
      console.log("innerHeight - top :" + (inner - targetEl_Top - paddingSum));

      if (phoneActive) {
        // スマートフォンからのアクセスだった場合

        // 横のスクロールバー分を差し引く
        const yscrollBar = 10;
        targetEl.style.maxHeight =
          inner - targetEl_Top - paddingSum - yscrollBar + "px";
      } else {
        targetEl.style.maxHeight = inner - targetEl_Top - paddingSum + "px";
      }
    },
  },
  // クリエイトライフサイクルフック
  created() {
    this.getFolderLists();
  },
  mounted() {
    this.setStyleFolserHeight();
    // console.log("mounted!!");
  },
};
</script>
<style>
/* 縦のスクロールバーの幅 */
#folder_height::-webkit-scrollbar {
  width: 10px;
}
/* 横のスクロールバーの幅 */
#folder_height::-webkit-scrollbar:horizontal {
  width: 5px;
}
#folder_height::-webkit-scrollbar-track {
  background: #fff;
  border: none;
  border-radius: 10px;
  box-shadow: inset 0 0 2px #777;
}
#folder_height::-webkit-scrollbar-thumb {
  background: #ccc;
  border-radius: 10px;
  box-shadow: none;
}
</style>
