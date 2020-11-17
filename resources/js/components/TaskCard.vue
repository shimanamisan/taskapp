<template>
    <div>
        <!-- ここからTaskList -->
        <div class="c-task__card__inner">
            <div class="c-task__todo">
                <div class="c-task__dragicon c-task__dragicon__card u-handle">
                    <i class="fas fa-bars u-handle"></i>
                </div>
                <div class="c-task__todo__header">
                    <span
                        v-if="!editFlag"
                        @dblclick="editCard"
                        @touchstart="editCard"
                        >{{ cardTitle }}</span
                    >
                    <form class="c-updateFrom" @submit.prevent v-else>
                        <!-- バリデーションエラー --->
                        <ul
                            v-if="cardRequestErrorMessages"
                            class="c-error c-error__tasks"
                        >
                            <li
                                v-for="(msg,
                                index) in cardRequestErrorMessages.title"
                                :key="index"
                            >
                                {{ msg }}
                            </li>
                        </ul>
                        <!--- end c-error -->
                        <input
                            type="text"
                            class="c-input c-input__tasks"
                            v-model="cardTitle"
                            @keypress.enter="updateCardTitle"
                            @keyup.esc="cancelEdit"
                            @blur="cancelEdit"
                            :class="{
                                'errors--bg': cardRequestErrorMessages,
                            }"
                        />
                    </form>
                    <label for class="c-task__todo--counter">{{
                        listCounter
                    }}</label>
                    <div class="c-task__todo--card--del">
                        <i class="fas fa-times" @click="deleteCard"></i>
                    </div>
                </div>
                <TaskListAdd :cards="cards" />
                <!-- c-task__todo--push -->
                <draggable
                    :list="cards.tasks"
                    v-bind="getOptionsForTask()"
                    @add="onAdd"
                    @change="onChange"
                    :data-card-id="cards.id"
                >
                    <TaskList
                        v-for="(task, index) in cards.tasks"
                        :key="task.id"
                        :id="task.id"
                        :title="task.title"
                        :listIndex="index"
                        :created_at="task.created_at"
                        :cards="cards"
                    />
                </draggable>
                <!-- <TaskList :cards="cards" /> -->
            </div>
            <!-- end c-task--todo -->
        </div>
        <!-- end c-task--card__inner -->
        <!-- ここまでTaskCard -->
    </div>
</template>
<script>
import { OK } from "@/statusCode";
import { mapState, mapGetters } from "vuex";
import draggable from "vuedraggable";
import TaskList from "@/components/TaskList";
import TaskListAdd from "@/components/Include/TaskListAdd";
import TaskCardAdd from "@/components/Include/TaskCardAdd";
export default {
    data() {
        return {
            editFlag: false,
            cardTitle: this.cards.title,
            inDrag: false,
        };
    },
    props: {
        cards: {
            type: Object,
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
    components: {
        TaskList,
        TaskListAdd,
        TaskCardAdd,
        draggable,
    },
    computed: {
        listCounter() {
            return this.cards.tasks.length;
        },
        ...mapState({
            cardRequestErrorMessages: (state) =>
                state.taskStore.cardRequestErrorMessages,
        }),
        ...mapGetters({
            getCode: "error/getCode",
        }),
    },
    methods: {
        // vue-draggableに指定するオプションを切り出し
        getOptionsForTask() {
            return { group: "cards.tasks", animation: 500 };
        },
        // sortAddClass(evt){
        //     // console.log(evt.item.getAttribute('data-task-id'))
        //     // console.log(evt.item)
        //     let targetTask = evt.item.getAttribute('data-task-id')
        //     evt.item.setAttribute('class', 'c-task__todo--list u-animetion')
        // },
        // sortRemoveClass(evt){
        //     console.log(evt.item)
        //     evt.item.setAttribute('class', 'c-task__todo--list')
        // },
        // カードを削除する
        async deleteCard() {
            const folder_id = this.cards.folder_id;
            const card_id = this.cards.id;
            // console.log( 'これはカードid：' + folder_id + '  ' + 'これはフォルダid：' + card_id)
            if (
                window.confirm(
                    "カードを削除すると、全てのタスクリストも削除されます。\nフォルダーを削除しますか？"
                )
            ) {
                await this.$store.dispatch("taskStore/deleteCard", {
                    folder_id: folder_id,
                    card_id: card_id,
                });

                if (this.getCode === OK) {
                    // 削除後データが更新されるので、選択されていたフォルダーを保持するための処理
                    await this.$store.dispatch(
                        "taskStore/setCardListsAction",
                        folder_id
                    );
                }
            }
        },
        // カードのタイトルを更新する
        async updateCardTitle() {
            const folder_id = this.cards.folder_id;
            const card_id = this.cards.id;
            await this.$store.dispatch("taskStore/updateCardTitle", {
                title: this.cardTitle,
                folder_id: folder_id,
                card_id: card_id,
            });

            if (this.getCode === OK) {
                await this.$store.dispatch(
                    "taskStore/setCardListsAction",
                    folder_id
                );
                this.editCard();
                // 更新後データが更新されるので、選択されていたフォルダーを保持するための処理
            }
        },
        // タスクリストの列の入れ替えを更新するアクションを呼ぶ
        async updateTaskDraggable(cardId, taskId) {
            await this.$store.dispatch("taskStore/updateTaskDraggable", {
                cardId: cardId,
                task_id: taskId,
            });
        },
        // タスクリストのソートを更新するアクションを呼ぶ
        async updateTaskSort(newTasks) {
            await this.$store.dispatch("taskStore/updateTaskSort", newTasks);
            const folder_id = this.cards.folder_id;
            if (this.getCode === OK) {
                await this.$store.dispatch(
                    "taskStore/setCardListsAction",
                    folder_id
                );
                // 更新後データが更新されるので、選択されていたフォルダーを保持するための処理
            }
        },
        // カードの更新フォームを呼び出す動作
        editCard() {
            this.editFlag = !this.editFlag;
            this.clearError();
        },
        // カードの更新フォームをキャンセルしたときの動作
        cancelEdit() {
            this.editFlag = false;
            // キャンセルしたときに、propsで渡ってきている元のデータをdataプロパティに代入する。
            this.cardTitle = this.cards.title;
            this.clearError();
        },
        /*************************************************
         * バリデーションメッセージを消すアクションを呼ぶ
         **************************************************/
        clearError() {
            this.$store.commit("taskStore/setCardRequestErrorMessages", null);
        },
        // draggableのイベントハンドラー：配列に要素が追加されたときに発火
        onAdd(event) {
            let fromCradId = event.from.getAttribute("data-card-id");
            let taskId = event.item.getAttribute("data-task-id");
            let toCardId = event.to.getAttribute("data-card-id");
            this.updateTaskDraggable(toCardId, taskId);
        },
        // draggableのイベントハンドラー：動作が開始され要素のコピーが行われた時
        // https://www.ritolab.com/entry/173
        onChange() {
            let newTasks = this.cards.tasks.map((task, index) => {
                task.priority = index + 1;
                return task;
            });
            this.updateTaskSort(newTasks);
        },
    },
};
</script>
<style></style>
