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
                            <label for="contact-name" class="c-form-lavel">お名前</label>
                            <!-- バリデーションエラー -->
                            <div v-if="contactErrors" class="errors">
                                <ul v-if="contactErrors.name">
                                    <li v-for="msg in contactErrors.password" :key="msg">{{ msg }}</li>
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
                            <label for="conatct-subject" class="c-form-lavel">お問い合わせ内容</label>
                            <!-- バリデーションエラー -->
                            <div v-if="contactErrors" class="errors">
                                <ul v-if="contactErrors.text">
                                    <li v-for="msg in contactErrors.text" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!-- end errors -->
                            <textarea id="conatct-subject" cols="30" rows="8" class="c-input" v-model="Form.subject"></textarea>
                            <p class="c-form__contact--text">{{ textCounter }}/2000文字以内</p>
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
import { mapState } from 'vuex'
export default {
  data (){
    return {
        Form: 
          {
            name:'',
            email:'',
            subject:''
          }
    }
  },
  computed: {
    // ...mapStateを使った書き方
    ...mapState({
      contactErrors: state => state.auth.contactMailErrorMessages
    }),
    textCounter(){
      return this.Form.subject.length
    }
  },
  methods: {
    // authストアのloginアクションを呼び出す
    async contactMessage(){
      if(window.confirm('お問い合わせ内容を送信します。\nよろしいですか？')){
        await this.$store.dispatch('auth/contactMessage', this.Form);
          if(this.apiStatus){
            
          }
      }
    },
    clearError(){
      this.$store.commit('auth/setLoginErrorMessages', null)
    },
    async twitterlogin(){
      await axios.get('/api/twitter')
      .then(response => {
        const URL = response.data.redirect_url
        window.location = URL
      }).
      catch(error => error.response || error)
    }
  },
    created(){
    // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
    this.clearError()
  }
}
</script>
<style>

</style>