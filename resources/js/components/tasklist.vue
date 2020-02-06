<template>
  <div>
    <Header/>
      <div class="c-task">
        <div class="c-task--content">
          <div class="c-task--borad01">
              <div class="c-task--borad02">
                  <div class="c-task--borad03">
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

                                              <div v-show="!FolderEdit_flg" class="c-task--todo--list c-task--todo--push" @click="FolderEdit_flg = !FolderEdit_flg">
                                                        ＋ 新しいフォルダを追加
                                                      </div>
                                                      <div v-show="FolderEdit_flg" class="c-task--todo--inputAreaWrapp">
                                                        <input type="input" class="c-task--todo--inputArea" v-model="FolderCreateForm">
                                                          <div class="l-flex u-btn--wrapp">
                                                              <div class="u-btn__profile--margin">
                                                                <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearFolderCreateForm">キャンセル</button>
                                                              </div>
                                                              <div class="u-btn__profile--margin">
                                                                <button class="c-btn c-btn--profile" @click="CreateFolder">追加</button>
                                                              </div>
                                                          </div><!-- l-flex -->
                                                      </div><!-- c-task--todo--push -->
                                    <div class="c-task--sidebar__wrapp c-task--folder">
                                      <div class="c-task--folder__wrapp">
                                        <i class="fas fa-bars c-task--folder__item"></i>
                                        <label for="">フォルダタイトル</label>
                                      </div>
                                    </div><!-- c-task--sidebar__wrapp -->
                                  </div><!-- c-task--sidebar -->

                          <Todo/>
                            
                          </div><!-- c-task--borad03 -->
                </div><!-- c-task--borad02 -->
            </div><!-- c-task--borad01 -->
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
      FolderEdit_flg: null,
      FolderCreateForm: '',
      FolderList: ''
    }
  },
  methods:{
    ClearFolderCreateForm(){
      this.FolderCreateForm = ''
      this.FolderEdit_flg = !this.FolderEdit_flg
    },
    async CreateFolder(){
      await this.$store.dispatch('taskStore/test', { folder: this.FolderCreateForm })
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
.c-task--cardbtn--inner{
 margin: 10px; 
}


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
