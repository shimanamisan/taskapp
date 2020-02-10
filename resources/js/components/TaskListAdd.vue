<template>
    <div>
        <div v-show="!TodoEdit_flg" class="c-task--todo--list c-task--todo--push" @click="TodoEdit_flg = !TodoEdit_flg">＋ 新しいタスクを追加 </div>
        <div v-show="TodoEdit_flg" class="c-task--todo--inputAreaWrapp">
            <form @submit.prevent>
                <input type="input" class="c-task--todo--inputArea" v-model="TodoCreateForm">
                <div class="l-flex u-btn--wrapp">
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearTodoCreateForm">キャンセル</button>
                    </div>
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile" >追加</button>
                    </div>
                </div>
                <!-- l-flex -->
            </form>
        </div>
    </div>
</template>
<script>
export default {
  data(){
    return{
      TodoEdit_flg: null,
      TodoCreateForm: '',
    }
  },
  methods:{
      ClearTodoCreateForm(){
      this.TodoCreateForm = ''
      this.TodoEdit_flg = !this.TodoEdit_flg
    }
  }
}
</script>
<style>

</style>