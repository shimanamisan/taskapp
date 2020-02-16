
const state = {
  FolderLists:[],
  CardLists:[]
/* 
FolderListsのデータ構造
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
  setFolderLists(state, FolderLists){
    state.FolderLists = FolderLists
  },
  setCardLists(state, CardLists){
    state.CardLists = CardLists
  }
}

/*******************************
アクション
********************************/
const actions = {
  // 全てのデータをステートにセット
  async setFolderLists( {commit} , payload){
    commit('setFolderLists', payload)
  },
  /*************************************
  リアクティブにデータを取得する
  *************************************/
  // フォルダー配下のカードをステートにセット
  async setCardLists( {commit} , id){
    const response = await axios.get('/api/folder/' + id + '/card').catch(error => error.response || error)
    var data = response.data.cards
    console.log(data)
    commit('setCardLists', data)
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
    commit('setFolderLists', data)
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
    commit('setFolderLists', data)
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}