import { OK, UNPROCESSABLE_ENTITY, CREATED } from '../statusCode'

const state = {
  FolderLists:[],
  CardLists:[],
  folder_id: '',
  card_id: '',
  task_id: '',
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
  },
  setFolder_id(state, id){
    state.folder_id = id
  },
  setCard_id(state, id){
    state.card_id = id
  },
  setTask_id(state, id){
    state.task_id = id
  },
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
  カードのデータを取得する
  *************************************/
  // フォルダー配下のカードをステートにセット
  async setCardLists( {commit} , id){
    // ここのIDはfolder_idのこと
    commit('setFolder_id', id)
    const response = await axios.get('/api/folder/' + id + '/card/set').catch(error => error.response || error)
    var data = response.data.cards
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
  },
  /*************************************
  カードの作成・更新・削除・並び替え
  *************************************/
  // カードの作成
  async createCard( { commit }, {title, id}){
    let card = {}
    card.title = title
    const response = await axios.post('/api/folder/' + id + '/card/create', card ).catch(error => error.response || error)
    var data = response.data.cards
    if(response.status === 500){
      console.log('500エラーです')
      return false
    }
    commit('setCardLists', data)
  }

  /*************************************
  タスクの作成・更新・削除・並び替え
  *************************************/
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}