
const state = {
  AllLists:[],
}

const getters = {
  
}

const mutations = {
  // タスクデータをステートへ格納
  setAllLists(state, AllLists){
      state.AllLists = AllLists
  }
}

const actions = {
  // async getAllLists( context ){
  //   const response = axios.get('/api/folder/user/' + id)
  // },
  async alllists({commit}, data){
    commit('setAllLists', data)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}