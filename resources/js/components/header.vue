<template>
  <header class="l-header__top">
  <div class="l-header__nav l-header__container">
    <div class="c-logo__header c-logo__clear-margin">
     <router-link to="/"><img src="../../img/log-top.png" alt="logo" class="c-logo-ind__header"></router-link>
    </div>
    <nav>
        <!-- <ul>
          <li><router-link to="register" class="c-btn c-header__signin">マイページ</router-link></li>
          <li><router-link to="login" class="c-btn c-header__login">ログアウト</router-link></li>
        </ul> -->
        <ul>
          <li><router-link to="register" class="c-btn c-header__signin">新規登録</router-link></li>
          <li><router-link to="login" class="c-btn c-header__login">ログイン</router-link></li>
        </ul>
    </nav>
  </div>
  </header>
</template>

<script>
export default {
    date(){
      return {
    
      }
    }
}
</script>

<style>

</style>