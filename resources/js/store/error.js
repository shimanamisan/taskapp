const state = {
    code: null,
};
const getters = {
    getCode: (state) => (state.code ? state.code : ""),
};

const mutations = {
    setCode(state, code) {
        state.code = code;
    },
};

export default {
    namespaced: true,
    state,
    mutations,
    getters,
};
