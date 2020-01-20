<template>
  <div class="l-wrapper l-wrapper__reminder">
  <section class="l-main__auth">
    <div class="c-logo__header">
      <router-link to="/"><img src="../../../img/logo.png" alt="logo" class="c-logo"></router-link>
    </div>
    <div class="l-card__container">
        <div class="p-card__container">
          <p class="p-card__title">認証画面</p>
        </div>
        <hr class="u-form__line">
        <div class="c-form__container">
            <form action="">
                <div class="c-form">
                  <label for="" class="c-form-lavel">認証キー</label>
                  <input type="text" class="c-input">
                </div>
            </form>
            <div class="c-form__action c-form__action__item">
              <a href="" class="c-btn c-btn__signin">送信する</a>
            </div>
      </div>
    </div><!-- l-card__container -->
    <div class="u-redirect__login">
      <router-link to="/reminder">⇦パスワード再発行メールを再度送信する</router-link>
    </div>
  </section><!-- l-main__auth -->
</div><!-- l-wrapper__login -->
</template>

<script>
export default {

}
</script>

<style>

</style>