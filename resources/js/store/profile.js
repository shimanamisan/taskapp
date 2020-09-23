import {
    OK,
    UNPROCESSABLE_ENTITY,
    INTERNAL_SERVER_ERROR,
    CREATED
} from "@/statusCode";

/*******************************
ステート
********************************/
const state = {
    /****************************************
  エラーメッセージ関係
  *****************************************/
    profileErrorMessages: null,
    successResponseMessage: null
};

/***********************************
ゲッター（アロー関数で短縮形で記述）
************************************/
const getters = {
    // お問い合わせバリデーション（お名前）
    validProfileNameError: state =>
        state.profileErrorMessages ? state.profileErrorMessages.name : "",
    // お問い合わせバリデーション（Email）
    validProfileEmailError: state =>
        state.profileErrorMessages ? state.profileErrorMessages.email : "",
    // パスワード変更バリデーション（現在のパスワード）
    validProfileOldPasswodError: state =>
        state.profileErrorMessages
            ? state.profileErrorMessages.old_password
            : "",
    // パスワード変更バリデーション（新しいパスワード）
    validProfilePasswodError: state =>
        state.profileErrorMessages ? state.profileErrorMessages.password : "",
    // 処理が成功した際の格納されたレスポンスメッセージを取得する
    getSuccessResponseMessage: state =>
        state.successResponseMessage ? successResponseMessage : ""
};

/*******************************
ミューテーション
********************************/
const mutations = {
    // プロフィールバリデーションメッセージをセット
    setProfileErrorMessages(state, messages) {
        state.profileErrorMessages = messages;
    },
    // レスポンスメッセージをセット
    setSuccessResponseMessage(state, message) {
        state.successResponseMessage = message;
    }
};

// アクション→コミットでミューテーション呼び出し→ステート更新
const actions = {
    /****************************************
  プロフィール編集
  *****************************************/
    // 画像変更
    async profileImageEdit({ commit }, data) {
        const id = data.user_id;
        console.log("actions " + id);
        console.log("actions " + data.img);
        const response = await axios.post("/api/profile/image/" + id, data.img);
        // 422ステータスの処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setProfileErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
        if (response.data.pic) {
            commit("auth/setPic", response.data.pic, { root: true });
        }
        commit("error/setCode", response.status, { root: true }); //{ root: ture }で違うファイルのミューテーションを呼べる
    },
    // 名前変更
    async profileNameEdit({ commit }, data) {
        const id = data.user_id;
        const response = await axios.post("/api/profile/name/" + id, data);
        // 422ステータスの処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setProfileErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
        if (response.data.name) {
            commit("auth/setUser", response.data.name, { root: true });
        }
        commit("error/setCode", response.status, { root: true });
    },
    // email変更
    async profileEmailEdit({ commit }, data) {
        const id = data.user_id;
        const response = await axios.post("/api/profile/email/" + id, {
            email: data.email
        });
        // 422ステータスの処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setProfileErrorMessages", response.data.errors);
        } else {
            console.log(response.data.success);
            commit("setSuccessResponseMessage", response.data.success);
            commit("error/setCode", response.status, { root: true });
        }
        commit("error/setCode", response.status, { root: true });
    },
    // パスワード変更
    async profilPasswordeEdit({ commit }, data) {
        const id = data.user_id;
        const response = await axios.post("/api/profile/password/" + id, data);
        // 422ステータスの処理
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setProfileErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
        commit("error/setCode", response.status, { root: true });
    },
    // ユーザー削除
    async userSoftDelete({ commit }) {
        commit("setApiStatus", null);
        const id = state.user_id;
        const response = await axios.delete("/api/profile/delete/" + id);
        if (response.status === INTERNAL_SERVER_ERROR) {
            commit("error/setCode", response.status, { root: true });
        } else if (response.status === OK) {
            commit("error/setCode", response.status, { root: true });
        }

        // 例外発生時でも、Laravel側でログアウトしているのでストアに持たせたログイン情報は削除する
        commit("setUser", null);
        commit("setEmail", null);
        commit("setPic", null);
        commit("setId", null);
        commit("setApiStatus", false);
        commit("error/setCode", response.status, { root: true });
    }
};

export default {
    namespaced: true,
    state,
    getters,
    mutations,
    actions
};
