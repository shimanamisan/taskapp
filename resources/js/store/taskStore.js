
const state = {
  AllLists:[],
}

const getters = {
  
}

const mutations = {
  // タスクデータをステートへ格納
  setAllLists(state, AllLists){
      state.AllLists = AllLists
  },

}

const actions = {
  async getAllLists( context ){
    const response = await axios.get('/api/folder/user/' + id)
  },
  async setAllLists({commit}, data){
    commit('setAllLists', data)
  },
  async createFolder( {commit}, title){
    // commit('createFolder', folderTitle)
    
    const response = await axios.post('/api/folder/add/', title).catch(error => error.response || error)
    
    return console.log(response)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}