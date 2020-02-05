<template>
  <div>
    <Header/>
      <div class="c-task">
        <div class="c-task-content">
          <div class="c-task-owner">
                  <div class="c-task--sidebar">
                    <div class="c-task--sidebar__wrapp">
                      <div class="c-task--sidebar__user">
                          <div class="c-task__avater">
                            <img src="https://placehold.jp/150x150.png" alt="">
                          </div>
                          <h1 class="c-task--sidebar__usertitle">ユーザー名</h1>
                      </div>
                    </div><!-- c-task--sidebar__wrapp -->
                    <hr class="u-task-line">

                    <div class="c-task--sidebar__wrapp c-task--folder">
                      <div class="c-task--folder__wrapp">
                        <i class="fas fa-bars c-task--folder__item"></i>
                        <label for="">フォルダタイトル</label>
                  
                      </div>
                  
                    </div>
                    <hr class="u-task-folder">
                    <div class="c-task--sidebar__wrapp">
                      <i class="fas fa-plus"></i>
                      <label for="">フォルダを追加する</label>
                      <input type="text">
                    </div>
                  </div><!-- c-task--sidebar -->

              <!-- ここからTODOリスト -->
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
                                      <div v-show="TodoEdit_flg" class="c-task--todo--textAreaWrapp">
                                        <input type="input" class="c-task--todo--textArea" v-model="todoInputForm">
                                          <div class="l-flex u-btn--wrapp">
                                              <div class="u-btn__profile--margin">
                                                <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearInputForm">キャンセル</button>
                                              </div>
                                              <div class="u-btn__profile--margin">
                                                <button class="c-btn c-btn--profile" >変更</button>
                                              </div>
                                          </div><!-- l-flex -->
                                      </div><!-- c-task--todo--push -->
                                  
                                  <div class="c-task--todo__card">
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
                                      <div class="c-task--todo--list">
                                        TODOリスト
                                      </div>
                                  </div>
                      </div><!-- end c-task--todo -->
                </div><!-- end c-task--card__inner -->         
              </div> <!-- ここまでTODOリスト -->
              <!-- ここからTODOリスト -->
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
                                      <div v-show="TodoEdit_flg" class="c-task--todo--textAreaWrapp">
                                        <input type="input" class="c-task--todo--textArea" v-model="todoInputForm">
                                          <div class="l-flex u-btn--wrapp">
                                              <div class="u-btn__profile--margin">
                                                <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearInputForm">キャンセル</button>
                                              </div>
                                              <div class="u-btn__profile--margin">
                                                <button class="c-btn c-btn--profile" >変更</button>
                                              </div>
                                          </div><!-- l-flex -->
                                      </div><!-- c-task--todo--push -->
                                  
                                  <div class="c-task--todo__card">
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
                                      <div class="c-task--todo--list">
                                        TODOリスト
                                      </div>
                                  </div>
                      </div><!-- end c-task--todo -->
                </div><!-- end c-task--card__inner -->         
              </div> <!-- ここまでTODOリスト -->
              <!-- ここからTODOリスト -->
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
                                      <div v-show="TodoEdit_flg" class="c-task--todo--textAreaWrapp">
                                        <input type="input" class="c-task--todo--textArea" v-model="todoInputForm">
                                          <div class="l-flex u-btn--wrapp">
                                              <div class="u-btn__profile--margin">
                                                <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearInputForm">キャンセル</button>
                                              </div>
                                              <div class="u-btn__profile--margin">
                                                <button class="c-btn c-btn--profile" >変更</button>
                                              </div>
                                          </div><!-- l-flex -->
                                      </div><!-- c-task--todo--push -->
                                  
                                  <div class="c-task--todo__card">
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
                                      <div class="c-task--todo--list">
                                        TODOリスト
                                      </div>
                                  </div>
                      </div><!-- end c-task--todo -->
                </div><!-- end c-task--card__inner -->         
              </div> <!-- ここまでTODOリスト -->



          </div>

         </div><!-- c-task-content -->
      </div>
  </div>
</template>

<script>
  import Header from './Header'
  import Todo from './Todo'
  import Message from './Message'

export default {
  data(){
    return{
      TodoEdit_flg: null,
      todoInputForm: '',
      todo: [],
    }
  },
  methods:{
    clearInputForm(){
      this.todoInputForm = ''
      this.TodoEdit_flg = !this.TodoEdit_flg
    }
  },
    components:{
      Header,
      Todo,
      Message
    }
}
</script>

<style>


::-webkit-scrollbar{
  width: 10px;
}
::-webkit-scrollbar-track{
  background: #fff;
  border: none;
  border-radius: 10px;
  box-shadow: inset 0 0 2px #777; 
}
::-webkit-scrollbar-thumb{
  background: #ccc;
  border-radius: 10px;
  box-shadow: none;
}
</style>
