<template>
  <div>
    <Header/>
      <div class="c-task">
        <div class="c-task__wrapp c-task__wrapp--primary">
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
                </div><!-- l-side-sub -->

  
             <div class="c-task--card">
               <div class="c-task--card__inner">

                        <div class="c-task--todo">
                                <div class="c-task--todo__header">
                                  フォルダタイトル
                                </div>
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
                                <div>
                                  <i class="fas fa-plus"></i>
                                  <label for="">新しいタスクを追加</label>
                                </div>
                                <input type="text">
                        </div>
               </div>
               <div class="c-task--card__inner">

                        <div class="c-task--todo">
                                <div class="c-task--todo__header">
                                  フォルダタイトル
                                </div>
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
                                <div>
                                  <i class="fas fa-plus"></i>
                                  <label for="">新しいタスクを追加</label>
                                </div>
                                <input type="text">
                        </div>
               </div>
            </div>

  

         </div><!-- l-side-wrapp__flex -->
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
      todo_flag: false,

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
