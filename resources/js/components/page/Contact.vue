<template>
    <div class="l-wrapper">
        <section class="l-main__auth">
            <div class="c-logo__header">
                <router-link to="/">
                    <img src="../../../img/logo.png" alt="logo" class="c-logo">
                </router-link>
            </div>
            <div class="l-card__container">
                <div class="l-card__content">
                    <div class="p-card__container">
                        <p class="p-card__title">お問い合わせ</p>
                        <hr class="u-form__line">
                    </div>
                </div>
                <!-- end content -->
                <div class="c-form__container">
                    <form @submit.prevent="contactMessage">
                        <div class="c-form__item">
                            <label for="contact-subject" class="c-form-lavel">件名</label>
                            <!-- バリデーションエラー -->
                            <div v-if="contactErrors" class="errors">
                                <ul v-if="contactErrors.subject">
                                    <li v-for="msg in contactErrors.subject" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input id="contact-subject" type="text" class="c-input" v-model="Form.subject">
                        </div>
                        <div class="c-form__item">
                            <label for="contact-name" class="c-form-lavel">お名前</label>
                            <!-- バリデーションエラー -->
                            <div v-if="contactErrors" class="errors">
                                <ul v-if="contactErrors.name">
                                    <li v-for="msg in contactErrors.name" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input id="contact-name" type="text" class="c-input" v-model="Form.name">
                        </div>
                        <!-- end c-form__item -->
                        <div class="c-form__item">
                            <label for="contact-email" class="c-form-lavel">メールアドレス</label>
                            <!-- バリデーションエラー -->
                            <div v-if="contactErrors" class="errors">
                                <ul v-if="contactErrors.email">
                                    <li v-for="msg in contactErrors.email" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <input id="contact-email" type="text" class="c-input" v-model="Form.email">
                        </div>
                        <!-- end c-form__item -->

                        <div class="c-form__item">
                            <label for="conatct-message" class="c-form-lavel">お問い合わせ内容</label>
                            <!-- バリデーションエラー -->
                            <div v-if="contactErrors" class="errors">
                                <ul v-if="contactErrors.message">
                                    <li v-for="msg in contactErrors.message" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <textarea id="conatct-message" cols="30" rows="8" class="c-input" v-model="Form.message"></textarea>
                            <p class="c-form__contact--text">{{ textCounter }}/1000文字以内</p>
                        </div>
                        <!-- end c-form__item -->
                        <div class="c-form__action--wrapp">
                            <div class="c-form__action">
                                <div class="c-form__action c-form__action__item">
                                  <router-link to="/">
                                    <button type="submit" class="c-btn c-btn__login c-btn__contact c-btn__contact--back">戻る</button>
                                  </router-link>
                                </div>
                            </div>
                            <div class="c-form__action">
                                <div class="c-form__action c-form__action__item">
                                    <button type="submit" class="c-btn c-btn__login c-btn__contact">送信する</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- c-form__container -->
            </div>
            <!-- l-card__container -->
        </section>
        <!-- l-main__auth -->
    </div>
    <!-- l-wrapper__login -->

</template>
<script>
import { OK } from '../../statusCode';
import { mapState, mapGetters } from 'vuex';
export default {
  data (){
    return {
        Form: 
          {
            subject: '',
            name:'',
            email:'',
            message:''
          }
    }
  },
  computed: {
    // ...mapStateを使った書き方
    ...mapState({
      contactErrors: state => state.auth.contactMailErrorMessages
    }),
    ...mapGetters({
      getCode: 'error/getCode'
    }),
    textCounter(){
      return this.Form.message.length;
    }
  },
  methods: {
    // authストアのloginアクションを呼び出す
    async contactMessage(){
      if(window.confirm('お問い合わせ内容を送信します。\nよろしいですか？')){
        await this.$store.dispatch('auth/contactMessage', this.Form);
          if(this.getCode === OK){
            alert('お問い合わせ内容は正しく送信されました。');
            this.Form.subject = '';
            this.Form.name = '';
            this.Form.email = '';
            this.Form.message = '';
            this.clearError();
          }
      }
    },
    clearError(){
      this.$store.commit('auth/setContactMailErrorMessages', null);
    },
  },
    created(){
    // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
    this.clearError();
  }
}
</script>
<style>

</style>