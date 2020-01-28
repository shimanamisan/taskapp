<template>
<div>
  <Header/>
      <div class="l-wrapper l-wrapper__profile">
        <section class="l-main__auth l-main__auth--profile">
      
        <div class="l-card__container">
            <div class="p-card__container">
              <p class="p-card__title">プロフィール編集</p>
            </div>
            <hr class="u-form__line">
            
                <form @submit.prevent="profileEdit">
                  <div class="c-form__container--profile">
                    <div class="c-form__item">
                      <label for="" class="c-form-lavel c-form-lavel__profile">プロフィール画像</label>
                        <!-- バリデーションエラー --->
                        <div v-if="profileUploadErrors" class="errors">
                          <ul v-if="profileUploadErrors.profilePhoto">
                            <li v-for="msg in profileUploadErrors.profilePhoto" :key="msg">{{ msg }}</li>
                          </ul>
                        </div><!--- end errors -->
                      <label class="c-input--profile">
                        <input type="file" class="c-input--profile__drop" @change="fileSelected">
                        <output v-if="preview">
                        <img :src="preview" alt="プロフィール画像" class="c-form__output">
                        <p v-show="showProfileImage"><img v-bind:src="profileData.pic" alt="プロフィール画像" class="c-form__output"></p>
                        </output>
                      </label>
                    </div>
                    <div>
                        <div class="c-form__item">
                          <label for="" class="c-form-lavel">ニックネーム</label>
                            <!-- バリデーションエラー --->
                            <div v-if="profileUploadErrors" class="errors">
                              <ul v-if="profileUploadErrors.email">
                                <li v-for="msg in profileUploadErrors.email" :key="msg">{{ msg }}</li>
                              </ul>
                            </div><!--- end errors -->
                          <input type="text" class="c-input" v-bind:value="profileData.name">
                        </div>
                        <div class="c-form__item">
                          <label for="" class="c-form-lavel">メールアドレス</label>
                            <!-- バリデーションエラー --->
                            <div v-if="profileUploadErrors" class="errors">
                              <ul v-if="profileUploadErrors.email">
                                <li v-for="msg in profileUploadErrors.email" :key="msg">{{ msg }}</li>
                              </ul>
                            </div><!--- end errors -->
                          <input type="text" class="c-input" v-bind:value="profileData.email">
                        </div>
                        <div class="c-form__item">
                          <label for="" class="c-form-lavel">変更後パスワード</label>
                          <input type="password" class="c-input" >
                        </div>
                        <div class="c-form__item">
                          <label for="" class="c-form-lavel">変更後パスワード再入力</label>
                          <input type="password" class="c-input" >
                        </div>
                    </div>
                  </div>
                  <div class="c-form__action c-form__action__item">
                    <button type="submit" class="c-btn c-btn__signin">更新する</button>
                  </div>
                </form>
        </div><!-- l-card__container -->

          <div class="l-card__container">
            <div class="p-card__container">
              <p class="p-card__title">アカウントの削除</p>
            </div>
            <hr class="u-form__line">
            <div class="c-form__container">
             <p>
              退会処理を行います。現在管理者
              であるプロジェクトは全て削除さ
              れ復旧はできません。
             </p>
          </div>
          <div class="c-form__action c-form__action__item">
            <button type="submit" class="c-btn c-btn__danger">削除する</button>
          </div>
        </div><!-- l-card__container -->
      </section><!-- l-main__auth -->
    </div><!-- l-wrapper__login -->
</div>
</template>

<script>
import { mapState } from 'vuex'
import Header from './header'

export default {
  data(){
    return {
      preview: null,
      profileImage: null,
      showProfileImage: null,
      profileData: 
          { 
            name:'',
            email:'',
            profileImg:'',
            password:'',
            password_confirmation: '',
          }
    }
  },
  computed: {
    profileUploadErrors(){
      return this.$store.state.auth.profileErrorMessages
    }
  },
  methods: {
      // フォームでファイルが選択されたら実行
      fileSelected(event){
        // Eventオブジェクトのtargetプロパティ内のfilesに選択したファイル情報が入っている
        console.log(event)
        // ファイル情報をdataプロパティに保存
        this.profileImage = event.target.files[0]
        // 何も選択されていなかったら処理を中断
        if(event.target.files.length === 0){
          this.reset() // プレビューの入力値を消すメソッドを作る
          return false
        }
        // ファイルが画像でなかったら処理を中断
        if(event.target.files[0].type.match('image.*')){
          return false
        }
        // FileReaderクラスのインスタンスを取得
        const reader = new FileReader()
        // ファイルを読み込み終わったタイミングで実行する処理
        reader.onload = event => {
          this.preview = event.target.result
        }
        // ファイルを読み込む
        // 読み込まれたファイルはデータURL形式で受け取れる
        reader.readAsDataURL(event.target.files[0])
        // 
        this.profileImage = event.target.files[0]
      },
      reset(){
        // コンポーネントに持たせたデータを消す
        this.preview = ""
        this.profileImage = null
        // this.$el.querySelectorでinput要素のDOMを取得して内部の値を消している
        this.$el.querySelector('input[type="file"]').value = null
      },
      // 入力欄の値とプレビュー表示を消すメソッド
      async profileEdit(){
        // プロフィール画像保存の処理
        /*
        1.フォームの値をlaravel側へ非同期で渡す
        2.laravel側でデータを受け取ってDBとストレージへ保存
        3.laravel側でその結果をJSON形式でリターン
        4.Vueでそれを受け取り変更結果を描画
        */
        // FormDataオブジェクトをインスタンス化
        const formData = new FormData()
        // appendメソッドでフィールドに追加（第1引数：キーを指定、第2引数：ファイル情報）
        // ここのキーとフォームリクエストクラスのバリデーションで指定したキーを同じにしてないと、常にリクエストが空とみなされてバリデーションに引っかかる
        formData.append('profilePhoto', this.profileImage)
        // アクションへファイル情報を渡す
        await this.$store.dispatch('auth/profileEdit', formData)
        this.reset()
      },
      clearError(){
        this.$store.commit('auth/setProfileErrorMessages', null)
      },
      getProfile(){
        axios.get('/api/user').then(response => {
          console.log('ライフサイクルフックでプロフィールを取得しています')
          this.profileData.name = response.data.name
          this.profileData.email = response.data.email
        }).catch(
          // ストアのアクションで管理したほうが良いか？
        )
      }
  },
  created(){
    // createdライフサイクルフックで、表示が残っていたバリデーションメッセージを消す
    this.clearError()
    this.getProfile()
  },
  components: {
    Header
  }
}
</script>

<style>

</style>