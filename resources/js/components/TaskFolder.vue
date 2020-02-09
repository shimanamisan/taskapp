<template>
<div>
    <div class="c-task--sidebar">
      <div class="c-task--sidebar__wrapp">
        <div class="c-task--sidebar__user">
          <div class="c-task__avater">
            <img src="https://placehold.jp/150x150.png" alt="">
          </div>
          <h1 class="c-task--sidebar__usertitle">ユーザー名</h1>
        </div>
      </div>
      <!-- c-task--sidebar__wrapp -->
      <hr class="u-task-line">
      <div v-show="!FolderEdit_flg" class="c-task--todo--list c-task--todo--push" @click="FolderEdit_flg = !FolderEdit_flg">＋ 新しいフォルダを追加 </div>
      <div v-show="FolderEdit_flg" class="c-task--todo--inputAreaWrapp">
        <input type="input" class="c-task--todo--inputArea" v-model="FolderCreateForm">
        <div class="l-flex u-btn--wrapp">
          <div class="u-btn__profile--margin">
            <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearFolderCreateForm">キャンセル</button>
          </div>
          <div class="u-btn__profile--margin">
            <button class="c-btn c-btn--profile" @click="CreateFolder">追加</button>
          </div>
        </div>
        <!-- l-flex -->
      </div>
      <!-- c-task--todo--push -->
      <div class="c-task--sidebar__wrapp c-task--folder">
        <div class="c-task--folder__wrapp">
          <i class="fas fa-bars c-task--folder__item"></i>
          <label for="">フォルダタイトル</label>
        </div>
      </div>
      <!-- c-task--sidebar__wrapp -->
    </div>
    <!-- c-task--sidebar -->
    <!-- TODOコンポーネント  -->
   
</div>

</template>
<script>

export default {
  components:{
  }
}
</script>
<style>

</style>