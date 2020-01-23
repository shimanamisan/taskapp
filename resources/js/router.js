import Vue from 'vue'
import VueRouter from 'vue-router'


// ルーティング用ページ
import Index from './components/index'
import TaskList from './components/tasklist'
import Login from './components/page/login'
import Register from './components/page/register'
import PasswordReminder from './components/page/passwordReminder'
import PasswordReset from './components/page/PasswordReset'
import SystemError from './components/page/error/SystemError.vue'

import store from './store/store'

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
      component: Login,
      
      // ナビゲーションガード
      beforeEnter(to, from, next){
        if(store.getters['auth/check']){
          next('/tasklist')
        }else{
          next()
        }
      }
    },
    {
      // ユーザー登録ページ
      path: '/register',
      component: Register,
        // ナビゲーションガード
        beforeEnter(to, from, next){
          // 新規登録ページにアクセスした際に、認証済みだったらタスクページに移動する
          if(store.getters['auth/check']){
            next('/tasklist')
          }else{
            next()
          }
        }
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
    },
    {
      // エラーページ
      path: '/500',
      component: SystemError
    }
  ]
})