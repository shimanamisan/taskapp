import { OK, UNPROCESSABLE_ENTITY, CREATED } from '../statusCode'

const state = {
  user: null,
  user_id: null,
  apiStatus: null, // API呼び出しが成功したか否か判断するためのステート。このステートを元に処理を判断する
  token: null,
  loginErrorMessages: null,
  registerErrorMessages: null
}

const getters = {
  // ログインチェックに使用。確実に真偽値を返すために二重否定をしている
  check: state => !! state.user,

  // usernameはログインユーザーの名前。仮にuserがnullの場合に呼ばれてもエラーにならない様に空文字にしている
  username: state => state.user ? state.user.name : ''
}

const mutations = {
  // ユーザー名を更新
  setUser(state, user){
    state.user = user
  },
  // ユーザーIDを更新
  setId(state, user_id){
    state.user_id = user_id
  },
  // トークンを入れる
  setToken(state, token){
    state.token = token
  },
  // ログイン状態を更新
  setApiStatus(state, status){
    state.apiStatus = status
  },
  // loginErrorMessagesステートのためのミューテーション
  setLoginErrorMessages (state, messages) {
    state.loginErrorMessages = messages
  },
  setRegisterErrorMessages (state, messages) {
    state.registerErrorMessages = messages
  }
}

// アクション→コミットでミューテーション呼び出し→ステート更新
const actions = {

  // ログイン処理
  async login( {commit} , data){
    // commitでミューテーションのsetApiStatus呼び出している、今回は引数に入るデータはnull
    commit('setApiStatus', null)
    // axiosで非同期でLaravelAPIを叩いてJSON形式でレスポンスをもらう
     await axios.post('/api/login', data).then(response => {
       console.log(response.data.token)
      const token = response.data.token;
      const name = response.data.user_name;
      const id = response.data.id;
      // ヘッダーにトークンを入れる
      axios.defaults.headers.common['Authorization'] = token;
      // ストアにトークンを入れる
      commit('setToken', token);
      // ログインステータスを変更する
      commit('setApiStatus', true)
      // ストア情報のユーザー情報を変更する
      commit('setUser', name)
      // ストア情報に取得したユーザーIDを入れる
      commit('setId', id )
      // ログインアナウンスを入れる
      // なにか入れる
    }).catch(error => {
      // ログイン失敗メッセージを入れる https://www.webopixel.net/javascript/1447.html
    });
    // if (response.status === OK) {
    //   return false
    // }
  },

  // ログアウト処理
  async logout (context) {
    context.commit('setApiStatus', null)
    const response = await axios.post('/api/logout')

    if (response.status === OK) {
      context.commit('setApiStatus', true)
      context.commit('setUser', null)
      return false
    }

    context.commit('setApiStatus', false)
    context.commit('error/setCode', response.status, { root: true })
  }

}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}