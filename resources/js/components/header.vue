<template>
  <header class="l-header l-header__nav l-header__container">
    <div class="c-logo__header c-logo__clear-margin">
      <router-link to="/">
        <img src="../../img/header-logo.png" alt="logo" class="c-logo" />
      </router-link>
    </div>
    <div class="l-header__menu--trigger" :class="toggleActive" @click="isActive = !isActive">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <nav class="sp-menu" :class="spMenuItem">
      <ul class="l-header__nav--list" v-if="isLogin">
        <li class="l-header__menu--item">
          <router-link to="/index" class="c-btn c-header__btn">TOP</router-link>
        </li>
        <li class="l-header__menu--item">
          <router-link to="/tasklist" class="c-btn c-header__btn">タスク管理ページ</router-link>
        </li>
        <li class="l-header__menu--item">
          <router-link to="/profile" class="c-btn c-header__btn">プロフィール編集</router-link>
        </li>
        <li class="l-header__menu--item">
          <span @click="logout" class="c-btn c-header__btn">ログアウト</span>
        </li>
      </ul>
      <ul class="l-header__nav--list" v-else>
        <li class="l-header__menu--item">
          <router-link to="/index" class="c-btn c-header__btn">TOP</router-link>
        </li>
        <li class="l-header__menu--item">
          <router-link to="register" class="c-btn c-header__btn">新規登録</router-link>
        </li>
        <li class="l-header__menu--item">
          <router-link to="login" class="c-btn c-header__btn">ログイン</router-link>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { mapState, mapGetters } from "vuex";
export default {
  data() {
    return {
      isActive: false
    };
  },
  computed: {
    ...mapState({
      apiStatus: state => state.auth.apiStatus
    }),
    ...mapGetters({
      isLogin: "auth/check"
    }),
    //   isLogin(){
    //    return this.$store.getters['auth/check']
    //   },
    //   apiStatus(){
    //     // authモジュールのapiStatusを参照
    //     return this.$store.state.auth.apiStatus
    //   },
    spMenuItem() {
      return {
        "sp-menu-Active": this.isActive
      };
    },
    toggleActive() {
      return {
        active: this.isActive
      };
    }
  },
  methods: {
    async logout() {
      await this.$store.dispatch("auth/logout");
      this.$router.push("/login");
    }
  }
};
</script>
<style>
</style>