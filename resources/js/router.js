import Vue from 'vue'
import VueRouter from 'vue-router'

// ルーティング用ページ
import Index from './components/index'
import TaskList from './components/tasklist'
import Login from './components/page/login'
import Register from './components/page/register'
import PasswordReminder from './components/page/passwordReminder'
import PasswordReset from './components/page/PasswordReset'

// vuexで使用するストアの読み込み


// vue-routerプラグインの読み込み
Vue.use(VueRouter);

//vue-routerのインスタンス化
export default new VueRouter({

  mode: 'history', // historyモードを指定
  routes: [
    {
      // リダイレクト用
      path: '*',
      redirect: '/'
    },
    {
      // Topページ
      path: '/',
      component: Index
    },
    {
      // ログインページ
      path: '/login',
      component: Login
    },
    {
      // ユーザー登録ページ
      path: '/register',
      component: Register
    },
    {
      // パスワードリマインダー
      path: '/reminder',
      component: PasswordReminder
    },
    {
      // パスワードリセット
      path: '/password/reset',
      component: PasswordReset
    },
    {
      // タスク管理ページ
      path: '/tasklist',
      component: TaskList
    }
  ]
})