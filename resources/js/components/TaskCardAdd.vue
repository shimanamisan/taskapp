<template>
    <div class="v-div">
        <div v-show="!CardEdit_flg" class="c-task--todo--list c-task--todo--push" @click="CardEdit_flg = !CardEdit_flg">＋ 新しいカードを追加 </div>
        <div v-show="CardEdit_flg" class="c-task--todo--inputAreaWrapp CardAdd">
            <form @submit.prevent>
                <input type="input" class="c-task--todo--inputArea" v-model="CradCreateForm">
                <div class="l-flex u-btn--wrapp">
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="clearCradCreateForm">キャンセル</button>
                    </div>
                    <div class="u-btn__profile--margin">
                        <button type="submit" class="c-btn c-btn--profile" @click="createCard">追加</button>
                    </div>
                </div>
                <!-- l-flex -->
            </form>
        </div>
        <!-- c-task--todo--inputAreaWrapp -->
    </div>
</template>
<script>
export default {
  data(){
    return{
      CardEdit_flg: null,
      CradCreateForm: '',
      folder_id: ''
    }
  },
  methods: {
    async createCard(){
      this.folder_id = this.$store.state.taskStore.folder_id
      await this.$store.dispatch('taskStore/createCard',
      {
        title: this.CradCreateForm,
        id: this.folder_id
      })

      this.clearCradCreateForm()
    },
    clearCradCreateForm(){
    this.CradCreateForm = ''
    this.CardEdit_flg = !this.CardEdit_flg
    },
    setFolderId(){
      this.folder_id = this.$store.state.taskStore.folder_id
      
    }
  }
}
</script>
<style>
.v-div{
  padding: 0 20px;
}
.CardAdd{
  padding: 0 20px 0 0;
}
</style>