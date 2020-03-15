import Vue from 'vue'
import VueRouter from 'vue-router'


// ルーティング用ページ
import Index from './components/index'
import TaskApp from './components/TaskApp'
import Profile from './components/Profile'
import Policy from './components/Policy'
import Rule from './components/Rule'
import Login from './components/page/Login'
import Register from './components/page/Register'
import PasswordReminder from './components/page/PasswordReminder'
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
      path: '/reset',
      component: PasswordReset
    },
    {
      // タスク管理ページ
      path: '/tasklist',
      component: TaskApp,
        // ナビゲーションガード
        beforeEnter(to, from, next){
        // 新規登録ページにアクセスした際に、認証済みだったらタスクページに移動する
        if(store.getters['auth/check']){
          next()
        }else{
          // 認証済みでなかったらログイン画面へ遷移
          next('/login')
        }
      }
    },
    {
      // プロフィールページ
      path: '/profile',
      component: Profile,
        // ナビゲーションガード
        beforeEnter(to, from, next){
        // 新規登録ページにアクセスした際に、認証済みだったらタスクページに移動する
        if(store.getters['auth/check']){
          // next('/profile')とすると、自分自身コンポーネント呼び出し続けてエラーになるので注意！
          next()
        }else{
          // 認証済みでなかったらログイン画面へ遷移
          next('/login')
        }
      }
    },
    {
      // プライバシーポリシー
      path: '/policy',
      component: Policy
    },
    {
      // 利用規約
      path: '/rule',
      component: Rule
    },
    {
      // エラーページ
      path: '/500',
      component: SystemError
    }
  ],
  scrollBehavior(){
    return new Promise(resolve => {
      setTimeout( () => {
        resolve({ x:0, y:0 })
      }, 500)
    })
  }
})