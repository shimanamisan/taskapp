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
                                    <draggable
                                        :forceFallback="true"
                                        :list="FolderLists"
                                        tag="ul"
                                        v-bind="{ animation: 300, delay: 50 }"
                                        handle=".handle"
                                        @change="onChange"
                                    >
                                        <TaskFolder
                                            class="handle"
                                            v-for="(folders,
                                            index) in FolderLists"
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
                            <div class="c-task--card">
                                <TaskCard
                                    v-for="(cards, index) in CardLists"
                                    :key="cards.id"
                                    :id="cards.id"
                                    :listIndex="index"
                                    :cards="cards"
                                />
                            </div>
                            <TaskCardAdd />
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
import Header from "@/components/Include/Header";
import TaskFolderProfile from "@/components/TaskFolderProfile";
import TaskFolderAdd from "@/components/TaskFolderAdd";
import TaskFolder from "@/components/TaskFolder";
import TaskCard from "@/components/TaskCard";
import TaskCardAdd from "@/components/TaskCardAdd";
import Message from "@/components/Message";
import { mapState, mapGetters } from "vuex";

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
        Message
    },
    computed: {
        // taskStore.jsのステート：FolderListsを常に参照している
        ...mapState({
            FolderLists: state => state.taskStore.FolderLists,
            CardLists: state => state.taskStore.CardLists
        })
    },
    methods: {
        async setFolderLists(data) {
            await this.$store.dispatch("taskStore/setFolderLists", data);
        },
        async getFolderLists() {
            await axios
                .get("/api/folder")
                .then(response => {
                    var data = response.data.folders;
                    // this.folderData = data
                    this.setFolderLists(data);
                })
                .catch(error => {
                    console.log(error);
                });
        },
        // フォルダのソート機能
        async updateFolderSort(newFolders) {
            await this.$store.dispatch(
                "taskStore/updateFolderSort",
                newFolders
            );
        },
        // vue-draggableをLaravelと連携するメソッド
        onChange() {
            // let newFolders = this.folderData.map((folder, index) => {
            let newFolders = this.FolderLists.map((folder, index) => {
                folder.priority = index + 1;
                return folder;
            });
            this.updateFolderSort(newFolders);
        }
    },
    // クリエイトライフサイクルフック
    created() {
        this.getFolderLists();
    },
    mounted() {
        const i = window.innerHeight;
        const test = document.getElementById("folder_height");
        test.style.minHeight = i - 312 + "px";
    }
};
</script>
<style>
::-webkit-scrollbar {
    width: 10px;
}
::-webkit-scrollbar-track {
    background: #fff;
    border: none;
    border-radius: 10px;
    box-shadow: inset 0 0 2px #777;
}
::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 10px;
    box-shadow: none;
}
</style>
