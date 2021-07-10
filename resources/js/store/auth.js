import {
    OK,
    UNPROCESSABLE_ENTITY,
    INTERNAL_SERVER_ERROR,
    CREATED,
} from "@js/statusCode";

const state = {
    username: null,
    user_id: null,
    email: null,
    password: null,
    profileImage: null,
    // レスポンスコードを格納するためのステート（200 403 500など）
    apiStatus: null,

    /****************************************
  メール送信メッセージ
  *****************************************/
    sendEmailMessages: null,

    /****************************************
  エラーメッセージ関係
  *****************************************/
    loginErrorMessages: null,
    registerErrorMessages: null,
    passwordReminderErrorMessages: null,
    resetPasswordErrorMessages: null,
};

/***********************************
ゲッター（アロー関数で短縮形で記述）
************************************/
const getters = {
    // ログインチェックに使用。確実に真偽値を返すために二重否定をしている
    check: (state) => !!state.username,
    // レスポンスコードをステートから取得する
    apiStatus: (state) => (state.apiStatus ? state.apiStatus : ""),
    // usernameはログインユーザーの名前。仮にuserがnullの場合に呼ばれてもエラーにならない様に空文字にしている
    getUserName: (state) => (state.username ? state.username : ""),
    // email情報を呼び出す
    getEmail: (state) => (state.email ? state.email : ""),
    // プロフィール写真のパスを呼び出す
    getProfileImage: (state) => (state.profileImage ? state.profileImage : ""),
    // 新規登録時のエラーメッセージの監視（Name）
    getRegisterNameError: (state) =>
        state.registerErrorMessages ? state.registerErrorMessages.name : "",
    // 新規登録時のエラーメッセージの監視（Email）
    getRegisterEmailError: (state) =>
        state.registerErrorMessages ? state.registerErrorMessages.email : "",
    // 新規登録時のエラーメッセージの監視（Password）
    getRegisterPasswordError: (state) =>
        state.registerErrorMessages ? state.registerErrorMessages.password : "",
    // ログイン時のエラーメッセージの監視（Email）
    getLoginEmailError: (state) =>
        state.loginErrorMessages ? state.loginErrorMessages.email : "",
    // ログイン時のエラーメッセージの監視（Password）
    getLoginPasswordError: (state) =>
        state.loginErrorMessages ? state.loginErrorMessages.password : "",
    // パスワードリセットメール送信時のエラーメッセージ監視（Email）
    validPasswordReminderErrorMessages: (state) =>
        state.passwordReminderErrorMessages
            ? state.passwordReminderErrorMessages.email
            : "",
    // パスワードリセットアクション時のエラーメッセージ監視（Email）
    validResetPasswordErrorMessagesForEmail: (state) =>
        state.resetPasswordErrorMessages
            ? state.resetPasswordErrorMessages.email
            : "",
    // パスワードリセットアクション時のエラーメッセージ監視（Password）
    validResetPasswordErrorMessagesForPassword: (state) =>
        state.resetPasswordErrorMessages
            ? state.resetPasswordErrorMessages.password
            : "",
};

/*******************************
ミューテーション
********************************/
const mutations = {
    // ユーザー名をセット
    setUser(state, username) {
        state.username = username;
    },
    // ユーザーIDをセット
    setId(state, user_id) {
        state.user_id = user_id;
    },
    // email情報をセット
    setEmail(state, email) {
        state.email = email;
    },
    // プロフィール写真のパスをセット
    setPic(state, profileImage) {
        state.profileImage = profileImage;
    },
    // ログイン状態を更新
    setApiStatus(state, status) {
        state.apiStatus = status;
    },
    // ログイン時のエラーハンドリングのためのミューテーション
    setLoginErrorMessages(state, messages) {
        state.loginErrorMessages = messages;
    },
    // 会員登録時のエラーハンドリング用ミューテーション
    setRegisterErrorMessages(state, messages) {
        state.registerErrorMessages = messages;
    },
    // パスワードリマインダー時のエラーハンドリング
    setPasswordReminderErrorMessages(state, message) {
        state.passwordReminderErrorMessages = message;
    },
    // パスワードリセットメール送信時のエラーメッセージ用ミューテーション
    setResetPasswordErrorMessages(state, message) {
        state.resetPasswordErrorMessages = message;
    },

    /****************************************
  メール送信メッセージ
  *****************************************/
    sendEmailMessages(state, message) {
        state.sendEmailMessages = message;
    },
};

// アクション→コミットでミューテーション呼び出し→ステート更新
const actions = {
    /****************************************
  会員登録
  *****************************************/
    // 第1引数にはコンテキストオブジェクトが渡される。その中にはcommitなどのメソッドが入っている
    // 第2引数にはサーバーから返却されたデータが入っている。何を返すかはコントローラー側で記述する
    async register({ commit }, data) {
        // commitでミューテーションのsetApiStatus呼び出している、最初には引数に入るデータはnull（初期化）
        commit("setApiStatus", null);
        const response = await axios.post("/api/register", data);
        // 200ステータスの処理
        if (response.status === CREATED) {
            const username = response.data.name;
            const id = response.data.id;
            // ログインステータスを変更する
            commit("setApiStatus", true);
            commit("setUser", username);
            // ストア情報に取得したユーザーIDを入れる
            commit("setId", id);
            return false;
        }
        commit("setApiStatus", false);
        // 422ステータスの処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setRegisterErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
        commit("error/setCode", response.status, { root: true }); //{ root: ture }で違うファイルのミューテーションを呼べる
    },
    /****************************************
  ログイン
  *****************************************/
    async login({ commit }, data) {
        // commitでミューテーションのsetApiStatus呼び出している、最初には引数に入るデータはnull
        commit("setApiStatus", null);
        // axiosで非同期でLaravelAPIを叩いてJSON形式でレスポンスをもらう
        const response = await axios.post("/api/login", data);
        // 200ステータスの処理
        if (response.status === OK) {
            commit("setApiStatus", true);
            const username = response.data.name;
            const email = response.data.email;
            const profileImage = response.data.pic;
            const id = response.data.id;
            // ログインステータスを変更する
            commit("setApiStatus", true);
            commit("setUser", username);
            commit("setEmail", email);
            commit("setPic", profileImage);
            // ストア情報に取得したユーザーIDを入れる
            commit("setId", id);
            return false;
        }
        // ステータスコード200以外の時の処理
        commit("setApiStatus", false);
        // 422ステータスの処理
        // バリデーションエラーに引っかかった時の処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            // レスポンスのエラーメッセージを格納
            commit("setLoginErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
    },
    /****************************************
  ログアウト
  *****************************************/
    async logout({ commit }) {
        commit("setApiStatus", null);
        const response = await axios.post("/api/logout");
        if (response.status === INTERNAL_SERVER_ERROR) {
            commit("error/setCode", response.status, { root: true });
        } else if (response.status === OK) {
            commit("setApiStatus", null);
            commit("setUser", null);
            commit("setEmail", null);
            commit("setPic", null);
            commit("setId", null);
            return false;
        }

        commit("setApiStatus", false);
        commit("error/setCode", response.status, { root: true });
    },

    /****************************************
  リロード時にログインチェック
  *****************************************/
    async currentUser({ commit }) {
        // apiStatusを初期化
        commit("setApiStatus", null);
        const response = await axios.get("/api/user");
        const user = response.data.name || null;
        if (response.status === OK) {
            commit("setApiStatus", true);
            commit("setUser", user);
            return false;
        }
        commit("setApiStatus", false);
        commit("error/setCode", response.status, { root: true });
    },
    /****************************************
  パスワードリマインダー
  *****************************************/
    async sendResetLinkEmail({ commit }, data) {
        const response = await axios.post("/api/password/reminder", {
            email: data,
        });
        console.log(response.data.errors);
        // 422ステータスの処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setPasswordReminderErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
            commit("sendEmailMessages", response.data.success);
        }
        commit("error/setCode", response.status, { root: true }); //{ root: ture }で違うファイルのミューテーションを呼べる
    },
    /****************************************
  パスワードリセット
  *****************************************/
    async resetPassword({ commit }, data) {
        const response = await axios.post("/api/password/reset", data);
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setResetPasswordErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
        commit("error/setCode", response.status, { root: true });
    },
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions,
};
