
const state = {
  AllLists:[],
  CardLists:[]
/* 
AllListsのデータ構造
  folders:[
    [
      {
        cards:[
          {
            tasks:
            [],
            [],
            [],
          }
      ],
        cards:[
          {
            tasks:
            [],
            [],
            [],
          }
      ],
        cards:[
          {
            tasks:
            [],
            [],
            [],
          }
      ],
    }
  ],
    [
      cards: {

    }
  ],
    [
      cards: {

    }
  ],    
]


*/
}

const getters = {
  
}

/*******************************
ミューテーション
********************************/
const mutations = {
  // タスクデータをステートへ格納
  setAllLists(state, AllLists){
    state.AllLists = AllLists
  },
  setCardLists(state, CardLists){
    state.CardLists = CardLists
  }
}

/*******************************
アクション
********************************/
const actions = {

  // async getAllLists( context ){
  //   const response = await axios.get('/api/folder/user/' + id)
  // },
  async setAllLists( {commit} , payload){
    commit('setAllLists', payload)
  },
  async setCardLists( {commit} , payload){
    commit('setCardLists', payload)
  },




  /*************************************
  フォルダー作成・更新・削除・並び替え
  *************************************/
  // フォルダーの作成
  async createFolder( {commit}, payload ){
    // commit('createFolder', payload)
    const response = await axios.post('/api/folder/create', payload).catch(error => error.response || error)
    var data = []
    var datas = response.data.folders
    for(var key in datas){
      data.push(datas[key])
    }
    commit('setAllLists', data)
  },
  // フォルダーの削除
  async deleteFolder( {commit}, id ){
    console.log('動作しています' + id)
    const response = await axios.delete('/api/folder/' + id + '/delete' ).catch(error => error.response || error)
    var data = []
    var datas = response.data.folders
    for(var key in datas){
      data.push(datas[key])
    }
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