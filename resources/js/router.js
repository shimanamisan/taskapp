import Vue from "vue";
import VueRouter from "vue-router";

// ルーティング用ページ
import Index from "./components/index";
import TaskApp from "./components/TaskApp";
import Profile from "./components/Profile";
import Policy from "./components/Policy";
import Rule from "./components/Rule";
import Callback from "./components/Callback";
import Login from "./components/page/Login";
import Register from "./components/page/Register";
import Contact from "./components/page/Contact";
import PasswordReminder from "./components/page/PasswordReminder";
import PasswordReset from "./components/page/PasswordReset";
import SystemError from "./components/page/error/SystemError.vue";

// vuexで使用するストアの読み込み
import store from "./store/store";

// vue-routerプラグインの読み込み
Vue.use(VueRouter);

//vue-routerのインスタンス化
export default new VueRouter({
    mode: "history", // historyモードを指定
    routes: [
        {
            // リダイレクト用
            path: "*",
            redirect: "/"
        },
        {
            // Topページ
            path: "/",
            component: Index,
            name: "Index", // push({ path: '/' }) のようにパス指定ではpropsが受け取れなかったので名前をつける
            props: true // propsを受け取れるようにする
        },
        {
            // ログインページ
            path: "/login",
            component: Login,
            // ナビゲーションガード
            beforeEnter(to, from, next) {
                // ログインページにアクセスした際に、認証済みだったらタスクページに移動する
                if (store.getters["auth/check"]) {
                    next("/tasklist");
                } else {
                    next();
                }
            }
        },
        {
            // ユーザー登録ページ
            path: "/register",
            component: Register,
            // ナビゲーションガード
            beforeEnter(to, from, next) {
                // 新規登録ページにアクセスした際に、認証済みだったらタスクページに移動する
                if (store.getters["auth/check"]) {
                    next("/tasklist");
                } else {
                    next();
                }
            }
        },
        {
            // パスワードリマインダー
            path: "/reminder",
            component: PasswordReminder
        },
        {
            // パスワードリセット
            path: "/reset",
            component: PasswordReset
        },
        {
            // タスク管理ページ
            path: "/tasklist",
            component: TaskApp,
            // ナビゲーションガード
            beforeEnter(to, from, next) {
                // 新規登録ページにアクセスした際に、認証済みだったらタスクページに移動する
                if (store.getters["auth/check"]) {
                    next();
                } else {
                    // 認証済みでなかったらログイン画面へ遷移
                    next("/login");
                }
            }
        },
        {
            // プロフィールページ
            path: "/profile",
            component: Profile,
            // ナビゲーションガード
            beforeEnter(to, from, next) {
                // 新規登録ページにアクセスした際に、認証済みだったらタスクページに移動する
                if (store.getters["auth/check"]) {
                    // next('/profile')とすると、自分自身コンポーネント呼び出し続けてエラーになるので注意！
                    next();
                } else {
                    // 認証済みでなかったらログイン画面へ遷移
                    next("/login");
                }
            }
        },
        {
            // お問い合わせページ
            path: "/contact",
            component: Contact
        },
        {
            // プライバシーポリシー
            path: "/policy",
            component: Policy
        },
        {
            // 利用規約
            path: "/rule",
            component: Rule
        },
        {
            // エラーページ
            path: "/500",
            component: SystemError
        },
        {
            // コールバックページ
            path: "/callback",
            component: Callback
        }
    ],
    // ページ下部のリンクから他のページに飛んでも、画面の位置を初期の位置に移動させるための処理
    scrollBehavior() {
        return new Promise(resolve => {
            setTimeout(() => {
                resolve({ x: 0, y: 0 });
            }, 500);
        });
    }
});
