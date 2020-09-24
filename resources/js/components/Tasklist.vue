<template>
    <div class="c-task__todo--list" :data-task-id="this.id">
        <div class="c-task__todo__wrapp">
            <div class="c-task__dragicon">
                <i class="fas fa-bars hand-icon"></i>
            </div>
            <span class="c-task__todo__item" v-if="!editFlag">{{ title }}</span>
            <form
                class="c-updateFrom c-updateFrom--TaskList"
                
                v-else
            >
                <!-- バリデーションエラー --->
                <!-- <ul v-if="taskRequestErrorMessages" class="errors errors--tasks">
                                  <li v-for="(msg, index) in taskRequestErrorMessages.title" :key="index">{{ msg }} </li>
        </ul>-->
                <!--- end errors -->
                <input
                    type="text"
                    class="c-input c-input__tasks"
                    v-model="taskTitle"
                    @keypress.enter="updateTaskTitle"
                    @keyup.esc="cancelEdit"
                    @blur="cancelEdit"
                    :class="{ 'errors--bg': taskRequestErrorMessages }"
                    :placeholder="placeholder"
                />
            </form>
            <div class="c-task__todo--list--del">
                <i
                    class="fas fa-edit c-task__folder--icon"
                    @click="editCard"
                ></i>
                <i class="fas fa-times" @click="deleteTask"></i>
            </div>
        </div>
        <i class="far fa-clock">
            <span class="c-task--todo--clock">{{ created_at }}</span>
        </i>
    </div>
</template>
<script>
import draggable from "vuedraggable";
export default {
    data() {
        return {
            editFlag: false,
            tasks: this.cards.tasks,
            taskTitle: this.title,
            folder_id: this.cards.folder_id,
            card_id: this.cards.id,
            task_id: this.id,
            placeholder: "入力必須です" // リファクタ必要
        };
    },
    components: {
        draggable
    },
    props: {
        cards: {
            type: Object,
            required: true
        },
        id: {
            type: Number,
            required: true
        },
        title: {
            type: String,
            required: true
        },
        listIndex: {
            type: Number,
            required: true
        },
        created_at: {
            type: String,
            required: true
        },
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
        async deleteTask() {
            if (window.confirm("タスクを削除しますか？")) {
                const folder_id = this.folder_id;
                const card_id = this.card_id;
                const task_id = this.task_id;
                await this.$store.dispatch("taskStore/deleteTask", {
                    folder_id: folder_id,
                    card_id: card_id,
                    task_id: task_id
                });
                // 削除後データが更新されるので、選択されていたフォルダーを保持するための処理
                await this.$store.dispatch(
                    "taskStore/setCardListsAction",
                    folder_id
                );
            }
        },
        async updateTaskTitle() {
            const folder_id = this.folder_id;
            const card_id = this.card_id;
            const task_id = this.task_id;
            await this.$store.dispatch("taskStore/updateTaskTitle", {
                title: this.taskTitle,
                folder_id: folder_id,
                card_id: card_id,
                task_id: task_id
            });
            await this.$store.dispatch(
                "taskStore/setCardListsAction",
                folder_id
            );

            if (this.getErrorCode === 200) {
                this.editCard();
                // 更新後データが更新されるので、選択されていたフォルダーを保持するための処理
            }
        },
        editCard() {
            this.editFlag = !this.editFlag;
            this.clearError();
        },
        cancelEdit() {
            this.editFlag = false;
            // キャンセルしたときに、propsで渡ってきている元のデータをdataプロパティに代入する。
            this.taskTitle = this.title;
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
.fa-clock {
    display: block;
    font-size: 12px;
}
.c-task--todo--clock {
    margin-left: 5px;
}
</style>
