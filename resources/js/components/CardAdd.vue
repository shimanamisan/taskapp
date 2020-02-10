<template>
    <div>
        <div v-show="!CardEdit_flg" class="c-task--todo--list c-task--todo--push" @click="CardEdit_flg = !CardEdit_flg">＋ 新しいカードを追加 </div>
        <div v-show="CardEdit_flg" class="c-task--todo--inputAreaWrapp">
            <form @submit.prevent>
                <input type="input" class="c-task--todo--inputArea" v-model="CradCreateForm">
                <div class="l-flex u-btn--wrapp">
                    <div class="u-btn__profile--margin">
                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="ClearCradCreateForm">キャンセル</button>
                    </div>
                    <div class="u-btn__profile--margin">
                        <button type="submit" class="c-btn c-btn--profile">追加</button>
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
    }
  },
  methods: {
    ClearCradCreateForm(){
    this.CradCreateForm = ''
    this.CardEdit_flg = !this.CardEdit_flg
    }
  }
}
</script>
<style>

</style>