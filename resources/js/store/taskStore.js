import { OK, UNPROCESSABLE_ENTITY, INTERNAL_SERVER_ERROR, CREATED } from '../statusCode'

const state = {
  FolderLists:[],
  CardLists:[],
  folder_id: '',

  /****************************************
  エラーメッセージ関係
  *****************************************/
  folderRequestErrorMessages: null,
  cardRequestErrorMessages: null,
  taskRequestErrorMessages: null,
}
/*******************************
ゲッター
********************************/
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
  setFolderRequestErrorMessages(state, folderRequestErrorMessages){
    state.folderRequestErrorMessages = folderRequestErrorMessages
  },
  setCardRequestErrorMessages(state, cardRequestErrorMessages){
    state.cardRequestErrorMessages = cardRequestErrorMessages
  },
  setTaskRequestErrorMessages(state, taskRequestErrorMessages){
    state.taskRequestErrorMessages = taskRequestErrorMessages
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
  // フォルダー配下のカードをステートにセットするアクション
  async setCardListsAction( {commit} , folder_id){
    // ここでストアへフォルダーIDを登録
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
    const response = await axios.post('/api/folder/create', payload).catch(error => error.response || error)
    // メソッドを使うために配列を定義
    var data = response.data.folders

    if(response.status === UNPROCESSABLE_ENTITY ){
      commit('setFolderRequestErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
      // ミューテーションへコミットする
      commit('setFolderLists', data)
    }
    commit('error/setCode', response.status, { root: true })    
  },
  // フォルダーの削除
  async deleteFolder( {commit}, folder_id ){
    const response = await axios.delete('/api/folder/' + folder_id + '/delete' ).catch(error => error.response || error)
    var data = response.data.folders
    if(response.status === UNPROCESSABLE_ENTITY ){
      commit('setFolderRequestErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
      // カードを作るためにセットしたフォルダーIDを一度リセットする
      commit('setFolder_id', null)
      // フォルダー削除後のデータをセットする
      commit('setFolderLists', data)
    }
    commit('error/setCode', response.status, { root: true })   
  },
  // フォルダータイトルの更新
  async updateFolderTitle( {commit} , {title, folder_id}){
    const folderTitle = {}
    folderTitle.title = title
    const response = await axios.put('/api/folder/' + folder_id + '/update', folderTitle).catch(error => error.response || error)
    var data = response.data.folders
    if(response.status === UNPROCESSABLE_ENTITY ){
      commit('setFolderRequestErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
      // ミューテーションへコミットする
      commit('setFolderLists', data) 
    }
    commit('error/setCode', response.status, { root: true })
  },
  // フォルダーの並び替えの更新
  async updateFolderSort({commit}, newFolder){
    const response = await axios.patch('/api/folder/update-all', {folders: newFolder}).catch(error => error.response || error)
    if(response.status ===   UNPROCESSABLE_ENTITY ){
    
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })

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
    if(response.status === UNPROCESSABLE_ENTITY ){
      commit('setCardRequestErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
    // 追加後のデータセットはフォルダー選択保持の為、setCardListsActionで行う
  },
  // カードの削除
  async deleteCard( { commit }, {folder_id, card_id}){
    const response = await axios.delete('/api/folder/' + folder_id + '/card/' + card_id + '/delete').catch(error => error.response || error)
    // 削除後のデータセットはフォルダー選択保持の為、setCardListsActionで行う
      if(response.status === UNPROCESSABLE_ENTITY ){
        commit('setCardRequestErrorMessages', response.data.errors)
      } else {
        commit('error/setCode', response.status, { root:true })
      }
      commit('error/setCode', response.status, { root: true }) 
  },
  // カードタイトルの更新
  async updateCardTitle({commit} , {title, folder_id, card_id }){
      const cardTitle = {}
      cardTitle.title = title
      const response = await axios.put('/api/folder/' + folder_id + '/card/' + card_id + '/update', cardTitle).catch(error => error.response || error)
      // 更新後のデータセットはフォルダー選択保持の為、setCardListsActionで行う
      if(response.status === UNPROCESSABLE_ENTITY ){
        commit('setCardRequestErrorMessages', response.data.errors)
      } else {
        commit('error/setCode', response.status, { root:true })
      }
      commit('error/setCode', response.status, { root: true })
  },
  // カードの並び替えの更新
  async updateCardSort(){

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
    // 422ステータスの処理
    if(response.status === UNPROCESSABLE_ENTITY ){
      commit('setTaskRequestErrorMessages', response.data.errors)
    } else {
      // 通信成功時のアクション
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
    
  },
  // タスクの削除
  async deleteTask( { commit }, {folder_id, card_id, task_id}){
    console.log('カード削除のアクションが動作しています' + task_id)
    const response = await axios.delete('/api/folder/' + folder_id + '/card/' + card_id + '/task/' + task_id + '/delete').catch(error => error.response || error)
    // 削除後のデータセットはフォルダー選択保持の為、setCardListsActionで行う
  },
  // タスクタイトルの更新
  async updateTaskTitle({commit} , {title, folder_id, card_id, task_id }){
    const taskTitle = {}
    taskTitle.title = title
    const response = await axios.put('/api/folder/' + folder_id + '/card/' + card_id + '/task/' + task_id  + '/update', taskTitle).catch(error => error.response || error)
    // 更新後のデータセットはフォルダー選択保持の為、setCardListsActionで行う
    if(response.status === UNPROCESSABLE_ENTITY ){
      commit('setTaskRequestErrorMessages', response.data.errors)
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
  },
  // タスクリストの列の入れ替え更新
  async updateTaskDraggable({commit}, {cardId, task_id}){
    console.log('updateTaskDraggable')
    // card_idは数値のみで渡ってくるので、key:value の形で渡してやるために一度オブジェクト形式で代入している
    // こうしなければ、Laravel側で$requestで受け取る際に、keyが無いものとしてnull値になってしまう
    // $request->card_id でキーを指定するとLaravel側でタスクIDの7が取得できる
    // カラムで指定している名前と合わせる(card_id)
    const card_id = {card_id: cardId}
    // card_idはオブジェクト形式で、{id: 7} の様に入ってくる。
    const response = await axios.put('/api/task/' + task_id, card_id).catch(error => error.response || error)
    if(response.status === UNPROCESSABLE_ENTITY ){
    
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
  },
  // タスクリストのソート更新
  async updateTaskSort({commit}, newTask){
    console.log('updateTaskSort')
    const response = await axios.patch('/api/task/update-all', {tasks: newTask}).catch(error => error.response || error)
    if(response.status === UNPROCESSABLE_ENTITY ){
    
    } else {
      commit('error/setCode', response.status, { root:true })
    }
    commit('error/setCode', response.status, { root: true })
  }
}

export default {
  namespaced: true,
  state,
  getters,
  mutations,
  actions
}