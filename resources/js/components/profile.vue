<template>
    <div>
        <Header/>
        <div class="l-wrapper l-wrapper__profile">
            <div class="l-main__auth l-main__auth--profile">
                <div class="l-card__container">
                    <div class="p-card__container">
                        <p class="p-card__title">プロフィール編集</p>
                    </div>
                    <hr class="u-form__line">
                    <div class="c-form__container--profile">
                        <div class="c-form__item">
                            <label for="" class="c-form-lavel c-form-lavel__profile">プロフィール画像</label>
                            <!-- バリデーションエラー --->
                            <div v-if="profileUploadErrors" class="errors">
                                <ul v-if="profileUploadErrors.profilePhoto">
                                    <li v-for="msg in profileUploadErrors.profilePhoto" :key="msg">{{ msg }}</li>
                                </ul>
                            </div>
                            <!--- end errors -->
                            <label class="c-input--profile" >
                                <input type="file" class="c-input--profile__drop" @change="fileSelected" @focus="imagefocus">
                                <output v-if="preview">
                                    <img v-bind:src="preview" alt="プロフィール画像" class="c-form__output">
                                    <p v-show="PreviewProfileImage">
                                        <img v-bind:src="profileData.pic" alt="プロフィール画像" class="c-form__output">
                                    </p>
                                </output>
                            </label>
                            <div class="l-flex u-btn--wrapp" v-show="showProfileImage">
                                <div class="u-btn__profile--margin">
                                    <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="reset">キャンセル</button>
                                </div>
                                <div class="u-btn__profile--margin">
                                    <button class="c-btn c-btn--profile" @click="ProfileImageEdit">変更</button>
                                </div>
                            </div>
                            <!-- l-flex -->
                        </div>
                        <!-- end c-form__item -->
                        <div>
                            <div class="c-form__item">
                                <label for="" class="c-form-lavel">ニックネーム</label>
                                <!-- バリデーションエラー --->
                                <div v-if="profileUploadErrors" class="errors">
                                    <ul v-if="profileUploadErrors.name">
                                        <li v-for="msg in profileUploadErrors.name" :key="msg">{{ msg }}</li>
                                    </ul>
                                </div>
                                <!--- end errors -->
                                <input type="text" class="c-input" v-model="profileData.name" @focus="namefocus">
                                <!-- 変更用ボタン -->
                                <div class="l-flex u-btn--wrapp" v-show="showName">
                                    <div class="u-btn__profile--margin">
                                        <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="cancelName">キャンセル</button>
                                    </div>
                                    <div class="u-btn__profile--margin">
                                        <button class="c-btn c-btn--profile" @click="ProfileNameEdit">変更</button>
                                    </div>
                                </div>
                                <!-- l-flex -->
                            </div>
                            <div class="c-form__item">
                                <label for="" class="c-form-lavel">メールアドレス</label>
                                <!-- バリデーションエラー --->
                                <div v-if="profileUploadErrors" class="errors">
                                    <ul v-if="profileUploadErrors.email">
                                        <li v-for="msg in profileUploadErrors.email" :key="msg">{{ msg }}</li>
                                    </ul>
                                </div>
                                <!--- end errors -->
                                <input type="text" class="c-input" v-model="profileData.email" @focus="emailfocus">
                            </div>
                            <!-- 変更用ボタン -->
                            <div class="l-flex u-btn--wrapp" v-show="showEmail">
                                <div class="u-btn__profile--margin">
                                    <button class="c-btn c-btn--profile c-btn--profile__cancel" @click="showEmail = !showEmail">キャンセル</button>
                                </div>
                                <div class="u-btn__profile--margin">
                                    <button class="c-btn c-btn--profile" @click="ProfileEmailEdit">変更</button>
                                </div>
                            </div>
                            <!-- l-flex -->
                            <div class="u-btn--wrapp u-btn--password">
                                <button class="c-btn c-btn--profile" @click="showPassword = !showPassword">パスワードの変更</button>
                            </div>
                        </div>
                    </div>
                    <!-- c-form__container--profile -->

                    <transition name="fade">
                        <div key="modal" class="c-modal" v-show="showPassword">
                            <div class="c-modal--body">
                                <div class="p-nav--trigger" @click="ShowPasswordTrigger">
                                    <i class="fas fa-times p-nav--close"></i>
                                </div>
                                <div class="c-form__item c-modal--inner">
                                    <label for="" class="c-form-lavel">新しいパスワード</label>
                                    <!-- バリデーションエラー --->
                                    <div v-if="profileUploadErrors" class="errors">
                                        <ul v-if="profileUploadErrors.password">
                                            <li v-for="msg in profileUploadErrors.password" :key="msg">{{ msg }}</li>
                                        </ul>
                                    </div>
                                    <!--- end errors -->
                                    <input type="password" class="c-input" v-model="profileData.password">
                                </div>
                                <!-- c-form__item -->
                                <div class="c-form__item">
                                    <label for="" class="c-form-lavel">新しいパスワード再入力</label>
                                    <!-- バリデーションエラー --->
                                    <div v-if="profileUploadErrors" class="errors">
                                        <ul v-if="profileUploadErrors.password_confirmation">
                                            <li v-for="msg in profileUploadErrors.password_confirmation" :key="msg">{{ msg }}</li>
                                        </ul>
                                    </div>
                                    <!--- end errors -->
                                    <input type="password" class="c-input" v-model="profileData.password_confirmation">
                                </div>
                                <div class="u-btn--wrapp u-btn--password c-modal--btn__passwordEdit">
                                    <button class="c-btn c-btn--profile" @click="ProfilPasswordeEdit">変更</button>
                                </div>
                            </div>
                        </div>
                        <!-- end c-modal -->
                    </transition>

                </div>
                <!-- l-card__container -->
                <div class="l-card__container">
                    <div class="p-card__container">
                        <p class="p-card__title">アカウントの削除</p>
                    </div>
                    <hr class="u-form__line">
                    <div class="c-form__container">
                        <p>退会処理を行います。現在管理者 であるプロジェクトは全て削除さ れ復旧はできません。 </p>
                    </div>
                    <div class="c-form__action c-form__action__item">
                        <button type="submit" class="c-btn c-btn__danger" @click="ProfileUserDelete">削除する</button>
                    </div>
                </div>
                <!-- l-card__container -->
            </div>
            <!-- l-main__auth -->
        </div>
        <!-- l-wrapper__profile -->
    </div>
</template>
<script>
import { mapState } from 'vuex'
import Header from './Header'

export default {
  data(){
    return {
      // ボタン表示フラグ
      showProfileImage: false,
      showName: false,
      showEmail: false,
      showPassword: false,
      
      // 画像プレビューフラグ
      preview: null,
      PreviewProfileImage: null,

      // プロフィールのフォームデータ
      profileData: 
          { 
            name:'',
            email:'',
            password:'',
            password_confirmation: '',
            profileImage: null,
          }
    }
  },
  computed: {
    // mapStateだと、メソッド内でthis.~で呼び出せなかった。
    // エラーコードで処理の振り分けを行うので、this.getErrorCodeで呼び出す必要があった
    // ...mapState({
    //   profileUploadErrors: state => state.auth.profileErrorMessages,
    //   getErrorCode: state => getters['error/code']
    // }),
    profileUploadErrors(){
      // エラーメッセージがあった際にストアより取得
      return this.$store.state.auth.profileErrorMessages
    },
    getErrorCode(){
      return this.$store.state.error.code
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
        // if(event.target.files[0].type.match('image.*')){
        //   return false
        // }
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
        this.profileData.profileImage = event.target.files[0]
      },
      reset(){
        // エラーメッセージが出ていたら消す
        this.clearError()
        // コンポーネントに持たせたデータを消す
        // this.preview = ""
        // this.profileImage = null
        // this.$el.querySelectorでinput要素のDOMを取得して内部の値を消している
        // this.$el.querySelector('input[type="file"]').value = null
        this.showProfileImage = !this.showProfileImage
      },
      // プロフィール写真変更
      async ProfileImageEdit(){
        // プロフィール画像保存の処理
        // FormDataオブジェクトをインスタンス化
        const formData = new FormData()
        // appendメソッドでフィールドに追加（第1引数：キーを指定、第2引数：valueを指定（ファイル情報））
        // ここのキーとフォームリクエストクラスのバリデーションで指定したキーを同じにしてないと、
        // 常にリクエストが空とみなされてバリデーションに引っかかる
        // formdataオブジェクトの中身を見る https://qiita.com/_Keitaro_/items/6a3342735d3429175300
        formData.append('profilePhoto', this.profileData.profileImage)
        // アクションへファイル情報を渡す
        await this.$store.dispatch('auth/ProfileImageEdit', formData)

        this.showProfileImage = !this.showProfileImage
      },
      async ProfileUserDelete(){
        // アクションを呼びに行く
        await this.$store.dispatch('auth/ProfileUserDelete')
      },
      async ProfileNameEdit(){
        // アクションへファイル情報を渡す
        await this.$store.dispatch('auth/ProfileNameEdit', { name: this.profileData.name } )
      
      },
      async ProfileEmailEdit(){
        // アクションへファイル情報を渡す
        await this.$store.dispatch('auth/ProfileEmailEdit', { email: this.profileData.email } )
     
      },
      async ProfilPasswordeEdit(){
        // アクションへファイル情報を渡す
        await this.$store.dispatch('auth/ProfilPasswordeEdit', 
        { 
          // これでkey:valueの形でデータをコントローラーへ渡せる
          password: this.profileData.password,
          password_confirmation: this.profileData.password_confirmation
        })
  
        if(this.getErrorCode === 200){
          // 送信後入力フォームを空にする
          this.profileData.password = '',
          this.profileData.password_confirmation = ''
          this.showPassword = !this.showPassword
          this.clearError()
        }
      },
      cancelPassword(){
        this.profileData.password = ''
        this.profileData.password_confirmation = ""
        this.clearError()
        this.showPassword = !this.showPassword
      },
      cancelName(){
        this.clearError()
        this.showName = !this.showName
      },
      ShowPasswordTrigger(){
        this.profileData.password = ''
        this.profileData.password_confirmation = ""
        this.clearError()
        this.showPassword = !this.showPassword
      },
      /****************************************
       * focus処理のメソッド
      *****************************************/
      namefocus(){
           if(this.showName === true){
          return
        }
        this.showName = !this.showName
      },
      emailfocus(){
        if(this.showEmail === true){
          return
        }
        this.showEmail = !this.showEmail
      },
      imagefocus(){
        if(this.showProfileImage === true){
          return
        }
        this.showProfileImage = !this.showProfileImage
      },
      /*************************************************
       * バリデーションメッセージを消すアクションを呼ぶ
      **************************************************/
      clearError(){
        this.$store.commit('auth/setProfileErrorMessages', null)
      },
      /*************************************************
       * マイページアクセス時にユーザー情報を取得
      **************************************************/
      getProfile(){
        axios.get('/api/user').then(response => {
          this.profileData.name = response.data.name
          this.profileData.email = response.data.email
          this.preview = response.data.pic
        }).catch({
  
        })
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