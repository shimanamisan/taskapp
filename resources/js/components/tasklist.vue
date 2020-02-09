<template>
 <div>


      <!-- ここからTaskList -->
      <div class="c-task--card">
          <div class="c-task--card__inner">
                    <div class="c-task--todo">
                          <div class="c-task--todo__header">
                          タスクタイトル
                          <label for="" class="c-task--todo--counter">0</label>
                            </div>

                                <div v-show="!TodoEdit_flg" class="c-task--todo--list c-task--todo--push" @click="TodoEdit_flg = !TodoEdit_flg">
                                  ＋ 新しいタスクを追加
                                </div>
                                <div v-show="TodoEdit_flg" class="c-task--todo--inputAreaWrapp">
                                  <input type="input" class="c-task--todo--inputArea" v-model="TodoCreateForm">
                                    <div class="l-flex u-btn--wrapp">
                                        <div class="u-btn__profile--margin">
                                          <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearTodoCreateForm">キャンセル</button>
                                        </div>
                                        <div class="u-btn__profile--margin">
                                          <button class="c-btn c-btn--profile" >追加</button>
                                        </div>
                                    </div><!-- l-flex -->
                                </div><!-- c-task--todo--push -->
                            
                            <div class="c-task--todo__card">
                                <div class="c-task--todo--list">
                                  TODOリスト
                                  <div class="c-task--todo--list--del">
                                    <i class="fas fa-times"></i>
                                  </div>
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                                <div class="c-task--todo--list">
                                  TODOリスト
                                </div>
                            </div>
                </div><!-- end c-task--todo -->
          </div><!-- end c-task--card__inner -->         
      </div> <!-- ここまでTaskList -->

      
              <div v-show="!CardEdit_flg" class="c-task--todo--list c-task--todo--push" @click="CardEdit_flg = !CardEdit_flg">
              ＋ 新しいカードを追加
              </div>
                  <div v-show="CardEdit_flg" class="c-task--todo--inputAreaWrapp">
                    <input type="input" class="c-task--todo--inputArea" v-model="CradCreateForm">
                        <div class="l-flex u-btn--wrapp">
                            <div class="u-btn__profile--margin">
                              <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearCradCreateForm">キャンセル</button>
                            </div>
                            <div class="u-btn__profile--margin">
                              <button class="c-btn c-btn--profile" >追加</button>
                            </div>
                        </div><!-- l-flex -->
                    </div><!-- c-task--todo--inputAreaWrapp -->
   
 </div>

</template>

<script>
export default {
  data(){
      return{
        CardEdit_flg: null,
        TodoEdit_flg: null,
        CradCreateForm: '',
        TodoCreateForm: '',
      }
  },
  methods: {
    ClearCradCreateForm(){
      this.CradCreateForm = ''
      this.CardEdit_flg = !this.CardEdit_flg
    },
    ClearTodoCreateForm(){
      this.TodoCreateForm = ''
      this.TodoEdit_flg = !this.TodoEdit_flg
    },
  }
}
</script>

<style>
.v-div{
  display: flex;
}
</style>