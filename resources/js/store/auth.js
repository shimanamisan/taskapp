import { OK, UNPROCESSABLE_ENTITY, CREATED } from '../statusCode'

const state = {
  username: null,
  user_id: null,
  email: null,
  password: null,
  profileImage: null,
  apiStatus: null, // API呼び出しが成功したか否か判断するためのステート。このステートを元に処理を判断する


  /****************************************
  エラーメッセージ関係
  *****************************************/
  loginErrorMessages: null,
  registerErrorMessages: null,
  profileErrorMessages: null,
  ProfileImageErrorMessages: null,
  ProfileNameErrorMessages: null,
  ProfileEmailErrorMessages: null,
  ProfilePasswordErrorMessages: null,
}

/*******************************
ゲッター
********************************/
const getters = {
  // ログインチェックに使用。確実に真偽値を返すために二重否定をしている
  check: state => !! state.username,

  // usernameはログインユーザーの名前。仮にuserがnullの場合に呼ばれてもエラーにならない様に空文字にしている
  username: state => state.username ? state.username : '',

  // email情報を呼び出す
  getEmail: state => state.email ? state.email : '',

  // プロフィール写真のパスを呼び出す
  getProfileImage: state => state.profileImage ? state.profileImage : '',
}

/*******************************
ミューテーション
********************************/
const mutations = {
  // ユーザー名をセット
  setUser(state, username){
    state.username = username
  },
  // ユーザーIDをセット
  setId(state, user_id){
    state.user_id = user_id
  },
  // email情報をセット
  setEmail(state, email){
    state.email = email
  },
  // プロフィール写真のパスをセット
  setPic(state, profileImage){
    state.profileImage = profileImage
  },
  // ログイン状態を更新
  setApiStatus(state, status){
    state.apiStatus = status
  },
  // ログイン時のエラーハンドリングのためのミューテーション
  setLoginErrorMessages(state, messages) {
    state.loginErrorMessages = messages
  },
  // 会員登録時のエラーハンドリング用ミューテーション
  setRegisterErrorMessages(state, messages) {
    state.registerErrorMessages = messages
  },
  // プロフィールバリデーションメッセージをセット
  setProfileErrorMessages(state, messages){
    state.profileErrorMessages = messages
  },
  // // プロフィール画像編集時のエラーハンドリング用ミューテーション
  // setProfileImageErrorMessages(state, messages){
  //   state.profileErrorMessages = messages
  // },
  // // 名前変更時のエラーハンドリング
  // setProfileNameErrorMessages(state, messages){
  //   state.profileErrorMessages = messages
  // },
  // // email変更時のエラーハンドリング
  // setProfileEmailErrorMessages(state, messages){
  //   state.profileErrorMessages = messages
  // },
  // // パスワード変更時のエラーハンドリング
  // setProfilePasswordErrorMessages(state, messages){
  //   state.profileErrorMessages = messages
  // },
}

// アクション→コミットでミューテーション呼び出し→ステート更新
const actions = {
  /****************************************
  会員登録
  *****************************************/
  // 第1引数にはコンテキストオブジェクトが渡される。その中にはcommitなどのメソッドが入っている
  // 第2引数にはサーバーから返却されたデータが入っている。何を返すかはコントローラー側で記述する
  async register( {commit} , data){
    // commitでミューテーションのsetApiStatus呼び出している、最初には引数に入るデータはnull
    commit('setApiStatus', null)
    const response = await axios.post('/api/register', data).catch(error => error.response || error)
      // 200ステータスの処理
      if(response.status === OK){
        const username = response.data.name;
        const id = response.data.id;
        // ログインステータスを変更する
        commit('setApiStatus', true)
        commit('setUser', username) 
        // ストア情報に取得したユーザーIDを入れる
        commit('setId', id )
        return false
      }
    commit('setApiStatus', false)
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      console.log('ステータスエラーです')
      commit('setRegisterErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true }) //{ root: ture }で違うファイルのミューテーションを呼べる
  },
  /****************************************
  ログイン
  *****************************************/
  async login( {commit} , data){
    // commitでミューテーションのsetApiStatus呼び出している、最初には引数に入るデータはnull
    commit('setApiStatus', null)
      // axiosで非同期でLaravelAPIを叩いてJSON形式でレスポンスをもらう
      const response = await axios.post('/api/login', data).catch(error => error.response || error)
      
      // パスワード情報は返却されていない
      console.log(response)
        // 200ステータスの処理
        if(response.status === OK){
          const username = response.data.name
          const email = response.data.email
          const profileImage = response.data.pic
          const id = response.data.id
          // ログインステータスを変更する
          commit('setApiStatus', true)
          commit('setUser', username) 
          commit('setEmail', email) 
          commit('setPic', profileImage) 
          // ストア情報に取得したユーザーIDを入れる
          commit('setId', id )
          return false
        }

      commit('setApiStatus', false)
      // 422ステータスの処理
      if(response.status === UNPROCESSABLE_ENTITY ){
        console.log('ステータスエラーです')
        commit('setLoginErrorMessages', response.data.errors)
      } else {
        commit('error/setCode', response.status, { root:true })
      }
      commit('error/setCode', response.status, { root: true }) //{ root: ture }で違うファイルのミューテーションを呼べる
  },
  /****************************************
  ログアウト
  *****************************************/
  async logout (context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')
    if (response.status === OK) {
      context.commit('setApiStatus', null)
      context.commit('setUser', null)
      context.commit('setEmail', null) 
      context.commit('setPic', null) 
      context.commit('setId', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },
  /****************************************
  プロフィール編集
  *****************************************/
  // 画像変更
  async ProfileImageEdit( {commit}, data){
    const id = state.user_id
    const response = await axios.post('/api/profile/image/' + id , data).catch(error => error.response || error)
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      console.log('ステータスエラーです')
      commit('setProfileErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true }) //{ root: ture }で違うファイルのミューテーションを呼べる
  },
  // 名前変更
  async ProfileNameEdit( {commit}, data){
    const id = state.user_id
    const response = await axios.post('/api/profile/name/' + id , data).catch(error => error.response || error)
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      console.log('ステータスエラーです')
      commit('setProfileErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('setUser', response.data.name) 
    commit('error/setCode', response.status, { root: true })

  },
  // email変更
  async ProfileEmailEdit( {commit}, data){
    const id = state.user_id
    const response = await axios.post('/api/profile/email/' + id , data).catch(error => error.response || error)
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      console.log('ステータスエラーです')
      commit('setProfileErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
  },
  // パスワード変更
  async ProfilPasswordeEdit( {commit}, data){
    const id = state.user_id
    console.log('ProfilPasswordeEdit' + JSON.stringify(data))
    const response = await axios.post('/api/profile/password/' + id , data).catch(error => error.response || error)
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      console.log('ステータスエラーです' + JSON.stringify(response.data.errors))
      commit('setProfileErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
  },
  /****************************************
  リロード時にログインチェック
  *****************************************/
  async currentUser (context) {
    const response = await axios.get('/api/user')    
    const loginUser = response.data || null
    console.log(loginUser)
    if(loginUser){
      context.commit('setApiStatus', true)
      context.commit('setUser', loginUser.name) 
      context.commit('setEmail', loginUser.email) 
      context.commit('setPic', loginUser.pic) 
      context.commit('setId', loginUser.id )
    }
  }

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}