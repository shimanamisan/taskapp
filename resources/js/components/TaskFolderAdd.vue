<template>
  <div>
    <div v-show="!FolderEdit_flg" class="c-task--todo--list c-task--todo--push" @click="FolderEdit_flg = !FolderEdit_flg">＋ 新しいフォルダを追加 </div>
    <div v-show="FolderEdit_flg" class="c-task--todo--inputAreaWrapp">
      <form @submit.prevent>
        <input type="text" class="c-task--todo--inputArea" v-model="FolderTitle">
        <div class="l-flex u-btn--wrapp">
          <div class="u-btn__profile--margin">
            <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearFolderCreateForm">キャンセル</button>
          </div>
          <div class="u-btn__profile--margin">
            <button type="submit" class="c-btn c-btn--profile" @click="CreateFolder">追加</button>
          </div>
        </div>
        <!-- end l-flex -->
      </form>
    </div>
    <!-- ebd c-task--todo--push -->
  </div>
</template>
<script>
export default {
  data(){
    return{
      FolderEdit_flg: null,
      FolderTitle: '',
    }
  },
  methods: {
    async CreateFolder(){
       await this.$store.dispatch('taskStore/test', { folder: this.FolderTitle })
       this.FolderTitle= ""
    },
    ClearFolderCreateForm(){
    this.FolderTitle = ''
    this.FolderEdit_flg = !this.FolderEdit_flg
    }
  }
}
</script>
<style>

</style>