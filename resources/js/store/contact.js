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
    contactMailErrorMessages: null
};

/***********************************
ゲッター（アロー関数で短縮形で記述）
************************************/
const getters = {
    // お問い合わせバリデーション（件名）
    validContactSubjectError: state => (state.contactMailErrorMessages ? state.contactMailErrorMessages.subject : ""),
    // お問い合わせバリデーション（お名前）
    validContactNameError: state => (state.contactMailErrorMessages ? state.contactMailErrorMessages.name : ""),
    // お問い合わせバリデーション（Email）
    validContactEmailError: state => (state.contactMailErrorMessages ? state.contactMailErrorMessages.email : ""),
    // お問い合わせバリデーション（お問い合わせ内容）
    validContactMessageError: state => (state.contactMailErrorMessages ? state.contactMailErrorMessages.message : ""),
};

/*******************************
ミューテーション
********************************/
const mutations = {
    setContactMailErrorMessages(state, message) {
        state.contactMailErrorMessages = message;
    }
};

// アクション→コミットでミューテーション呼び出し→ステート更新
const actions = {
    /****************************************
  お問い合わせメール送信
  *****************************************/
    async contactMessage({ commit }, data) {
        const response = await axios.post("/api/contact", data);
        if (response.status === UNPROCESSABLE_ENTITY) {
            commit("setContactMailErrorMessages", response.data.errors);
        } else {
            commit("error/setCode", response.status, { root: true });
        }
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
