import { OK, UNPROCESSABLE_ENTITY, CREATED } from '../statusCode'

const state = {
  username: null,
  user_id: null,
  apiStatus: null, // API呼び出しが成功したか否か判断するためのステート。このステートを元に処理を判断する
  loginErrorMessages: null,
  registerErrorMessages: null
}

/*******************************
ゲッター
********************************/
const getters = {
  // ログインチェックに使用。確実に真偽値を返すために二重否定をしている
  check: state => !! state.username,

  // usernameはログインユーザーの名前。仮にuserがnullの場合に呼ばれてもエラーにならない様に空文字にしている
  username: state => state.username ? state.username : '',

  // ログイン時のエラーメッセージ
  loginErrorMessages: state => !! state.loginErrorMessages,

  // 新規登録時のエラーメッセージ
  registerErrorMessages: state => !! state.registerErrorMessages
}

/*******************************
ミューテーション
********************************/
const mutations = {
  // ユーザー名を更新
  setUser(state, username){
    state.username = username
  },
  // ユーザーIDを更新
  setId(state, user_id){
    state.user_id = user_id
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
  }
}

// アクション→コミットでミューテーション呼び出し→ステート更新
const actions = {
  // 会員登録
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
    console.log(response.status)
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      console.log('「auth.jsのregisterメソッドです」：' + JSON.stringify(response.data.errors))
      commit('setRegisterErrorMessages', response.data.errors)
    } else {
      commit('erroe/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true }) //{ root: ture }で違うファイルのミューテーションを呼べる
  },
  //ログイン
  async login( {commit} , data){
    // commitでミューテーションのsetApiStatus呼び出している、最初には引数に入るデータはnull
    commit('setApiStatus', null)
      // axiosで非同期でLaravelAPIを叩いてJSON形式でレスポンスをもらう
      const response = await axios.post('/api/login', data).catch(error => error.response || error)
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
      console.log(response.status)
      // 422ステータスの処理
      if(response.status === UNPROCESSABLE_ENTITY ){
        commit('setLoginErrorMessages', response.data.errors)
      } else {
        commit('erroe/setCode', response.status, { root:true })
      }
      commit('error/setCode', response.status, { root: true }) //{ root: ture }で違うファイルのミューテーションを呼べる
  },
  // ログアウト処理
  async logout (context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')
    if (response.status === OK) {
      context.commit('setApiStatus', null)
      context.commit('setUser', null)
      context.commit('setId', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  },

  // 
  // 起動時にログインチェック
  async currentUser (context) {
    const response = await axios.get('/api/user')    
    const user = response.data || null
    if(user){
      context.commit('setApiStatus', true)
      context.commit('setUser', user.name) 
      context.commit('setId', user.id )
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