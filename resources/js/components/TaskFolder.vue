<template>
    <div>
        <li
            class="c-task__folder__wrapp u-handle"
            :class="currentFolder(this.id)"
            @click="setCardLists"
        >
            <div class="c-task__dragicon">
                <i class="fas fa-bars"></i>
            </div>
            <span class="c-task__folder__item" v-if="!editFlag">{{
                folderTitle
            }}</span>

            <form class="c-updateFrom" @submit.prevent v-else>
                <!-- バリデーションエラー --->
                <ul
                    v-if="folderRequestErrorMessages"
                    class="c-error c-error__tasks"
                >
                    <li
                        v-for="(msg, index) in folderRequestErrorMessages.title"
                        :key="index"
                    >
                        {{ msg }}
                    </li>
                </ul>
                <!--- end errors -->
                <input
                    type="text"
                    class="c-input c-input__tasks"
                    v-model="folderTitle"
                    @keypress.enter="updateFolderTitle"
                    @keyup.esc="cancelEdit"
                    @blur="cancelEdit"
                    :class="{ 'c-error__bg': folderRequestErrorMessages }"
                />
            </form>
            <div class="c-task__folder__trash">
                <i
                    class="fas fa-edit c-task__folder--icon"
                    @click="editFolder"
                ></i>
                <i class="fas fa-trash-alt" @click="deleteFolder"></i>
            </div>
        </li>
    </div>
</template>
<script>
import { mapState, mapGetters } from "vuex";
import { OK } from "@/statusCode";
import draggable from "vuedraggable";

export default {
    data() {
        return {
            editFlag: false,
            folderTitle: this.title,
            folderActive: "c-task__folder__wrapp--active",
            folderDisable: ""
        };
    },
    components: {
        draggable
    },
    props: {
        title: {
            type: String,
            required: true
        },
        id: {
            type: Number,
            required: true
        },
        listIndex: {
            type: Number,
            required: true
        }
    },
    computed: {
        ...mapState({
            // エラーメッセージがあった際にストアより取得
            folderRequestErrorMessages: state =>
                state.taskStore.folderRequestErrorMessages
        }),
        ...mapGetters({
            getCode: "error/getCode",
            current_folderId: "taskStore/current_folderId"
        })
    },
    methods: {
        // フォルダーを選択したら、そのフォルダーのカードリストをセットする
        async setCardLists() {
            const folder_id = this.id;
            await this.$store.dispatch(
                "taskStore/setCardListsAction",
                folder_id
            );
        },
        //
        currentFolder(folder_id) {
            if (folder_id === this.current_folderId) {
                return this.folderActive;
            } else {
                return this.folderDisable;
            }
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
        // フォルダーのタイトルを更新する
        async updateFolderTitle() {
            await this.$store.dispatch("taskStore/updateFolderTitle", {
                title: this.folderTitle,
                folder_id: this.id
            });
            if (this.getCode === OK) {
                this.editFolder();
            }
        },
        /*************************************************
         * バリデーションメッセージを消すアクションを呼ぶ
         **************************************************/
        clearError() {
            this.$store.commit("taskStore/setFolderRequestErrorMessages", null);
        }
    }
};
</script>
<style>
.fa-edit {
    margin-right: 5px;
}
</style>
