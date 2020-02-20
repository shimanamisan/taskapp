import { OK, UNPROCESSABLE_ENTITY, INTERNAL_SERVER_ERROR, CREATED } from '../statusCode'

const state = {
  FolderLists:[],
  CardLists:[],
  folder_id: '',
  card_id: '',
  task_id: '',

  /****************************************
  エラーメッセージ関係
  *****************************************/
  requestErrorMessages: null,
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
    console.log( 'アクションsetFolderLists()です。フォルダーの取得をして、FolderListsストアを更新しています。')
    commit('setFolderLists', payload)
  },
  /*************************************
  カードのデータを取得する
  *************************************/
  // フォルダー配下のカードをステートにセット
  async setCardLists( {commit} , folder_id){
    console.log( 'アクションsetCardLists()です。フォルダー配下のカードを取得するために、CardListsストアを更新しています。')
    commit('setFolder_id', folder_id)
    const response = await axios.get('/api/folder/' + folder_id + '/card/set').catch(error => error.response || error)
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
  async deleteFolder( {commit}, folder_id ){
    console.log('フォルダー削除のアクションが動作しています。' + ' フォルダーID：' + folder_id)
    const response = await axios.delete('/api/folder/' + folder_id + '/delete' ).catch(error => error.response || error)
    var data = []
    var datas = response.data.folders
    if(response.status === INTERNAL_SERVER_ERROR){
      console.log('INTERNAL_SERVER_ERRORです')
      return false
    }
    for(var key in datas){
      data.push(datas[key])
    }
    commit('setFolderLists', data)
  },
  /*************************************
  カードの作成・更新・削除・並び替え
  *************************************/
  // カードの作成
  async createCard( { commit }, {title, folder_id}){
    // Laravel側へオブジェクトとしてデータを渡すために作成
    const card = {}
    // titleプロパティにフォームの値をセット
    card.title = title
    const response = await axios.post('/api/folder/' + folder_id + '/card/create', card ).catch(error => error.response || error)
    var data = response.data.cards
    if(response.status === INTERNAL_SERVER_ERROR){
      console.log('INTERNAL_SERVER_ERRORです')
      return false
    }
    commit('setCardLists', data)
  },
  // カードの削除
  async deleteCard( { commit }, {folderId, cardId}){
    console.log('カード削除のアクションが動作しています')
    const response = await axios.delete('/api/folder/' + folderId + '/card/' + cardId + '/delete').catch(error => error.response || error)
    var data = response.data.cards
    if(response.status === INTERNAL_SERVER_ERROR){
      console.log('INTERNAL_SERVER_ERRORです')
      return false
    }
    commit('setCardLists', data)
  },

  /*************************************
  タスクの作成・更新・削除・並び替え
  *************************************/
 // タスクの作成
  async createTask( { commit }, {title, folder_id, card_id}){
    const task = {}
    // titleプロパティにフォームの値をセット
    task.title = title
    const response = await axios.post('/api/folder/' + folder_id + '/card/' + card_id + '/task/create', task ).catch(error => error.response || error)
    // /folder/{folder_id}/card/{card_id}/task/create
    var data = response.data.cards
    if(response.status === INTERNAL_SERVER_ERROR){
      console.log('INTERNAL_SERVER_ERRORです')
      return false
    }
    console.log('ここまでアクションOK')
    return false
    commit('setCardLists', data)
  },
  // タスクの削除
  async deleteTask( { commit }, {folderId, cardId}){
    console.log('カード削除のアクションが動作しています')
    const response = await axios.delete('/api/folder/' + folderId + '/card/' + cardId + '/delete').catch(error => error.response || error)
    var data = response.data.cards
    if(response.status === INTERNAL_SERVER_ERROR){
      console.log('INTERNAL_SERVER_ERRORです')
      return false
    }
    commit('setCardLists', data)
  }



}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}