<template>
  <div>
    <Header/>
    
      <section class="l-side">
        <div class="l-side-wrapp__flex">
            <div class="l-side-sub">
              <div class="l-side-wrapp">
                <div class="l-side-user">
                    <div class="c-task-img">
                      <img src="https://placehold.jp/150x150.png" alt="">
                    </div>
                    <h1 class="c-task-user">ユーザー名</h1>
                </div>
              </div>
              <hr class="u-task-line">

              <div class="l-side-wrapp">
                <div class="c-task-wrapp">
                  <i class="fas fa-bars c-task-item"></i>
                  <label for="">フォルダタイトル</label>
                  <div class="c-task-wrapp__icon">
                    <i class="fas fa-edit c-task-item c-task-item__edit"></i>
                    <i class="fas fa-trash-alt c-task-item c-task-item__trash"></i>
                  </div>
                </div>
                <div class="c-task-wrapp">
                  <i class="fas fa-bars c-task-item"></i>
                  <label for="">フォルダタイトル</label>
                  <div class="c-task-wrapp__icon">
                    <i class="fas fa-edit c-task-item c-task-item__edit"></i>
                    <i class="fas fa-trash-alt c-task-item c-task-item__trash"></i>
                  </div>
                </div>
                <div class="c-task-wrapp">
                  <i class="fas fa-bars c-task-item"></i>
                  <label for="">フォルダタイトル</label>
                  <div class="c-task-wrapp__icon">
                    <i class="fas fa-edit c-task-item c-task-item__edit"></i>
                    <i class="fas fa-trash-alt c-task-item c-task-item__trash"></i>
                  </div>
                </div>
              </div>
              <hr class="u-task-folder">
              <div class="l-side-wrapp">
                <i class="fas fa-plus"></i>
                <label for="">フォルダを追加する</label>
                <input type="text">
              </div>

      
            </div><!-- l-side-sub -->

            <div class="l-side-main">
              <div class="l-side-wrapp l-side-wrapp__taskbox">
                サンプルテキスト
                <div class="c-task">
                  フォルダタイトル
                </div>
                <div>
                  TODOリスト
                </div>
                <div>
                  <i class="fas fa-plus"></i>
                  <label for="">新しいタスクを追加</label>
                </div>
                <input type="text">
              </div>
            </div>
            <div class="l-side-main">
              <div class="l-side-wrapp l-side-wrapp__taskbox">
                サンプルテキスト
                <div class="c-task">
                  フォルダタイトル
                </div>
                <div>
                  TODOリスト
                </div>
                <div>
                  <i class="fas fa-plus"></i>
                  <label for="">新しいタスクを追加</label>
                </div>
                <input type="text">
              </div>
            </div>
        </div>
      </section>
  </div>
</template>

<script>
  import Header from './header'

export default {
    components:{
      Header
    }
}
</script>

<style>

</style>
