<template>
<div>
  <Header/>
        <div class="l-wrapper__top">
              <section class="l-section__first">
                <div class="p-eyecatch u-inner">
                  <div class="u-ind-wrapp__sub">
                    <div class="c-logo__header c-logo__clear-margin">
                      <img src="../../img/log-top.png" alt="logo" class="c-logo__top">
                      <h1 class="p-eyecatch__header">簡単な操作で軽快にタスクをこなそう</h1>
                    </div>
                    <div>
                      <img src="https://placehold.jp/550x350.png" alt="">
                    </div>
                  </div>
                </div>
              </section>

              <section class="l-section l-section__second">
                <div class="u-inner">
                    <h2 class="u-title p-title">こんなことでお悩みではないですか？</h2>
                      <div class="l-section-wrapp l-section-wrapp__flex">
                        <div class="p-card p-card-border">
                          <img src="../../img/panel/001.png" alt="">
                          <div class="p-card-content">
                            <p>
                              機能が多すぎて使い方を覚える時間が煩わしい
                            </p>
                          </div>
                        </div>
                        <div class="p-card p-card-border">
                          <img src="../../img/panel/002.png" alt="">
                          <div class="p-card-content">
                            <p>
                              スマホから使うと動作が重くてストレスを感じる
                            </p>
                          </div>
                        </div>
                        <div class="p-card p-card-border">
                          <img src="../../img/panel/003.png" alt="">
                          <div class="p-card-content">
                            <p>
                              簡素な機能でもっと直感的に扱うアプリが欲しい
                            </p>
                          </div>
                        </div>
                    </div>
                </div>
              </section>
              
              <section class="l-section l-section__third">
                <div class="u-inner">
                    <div class="l-section-wrapp l-section-wrapp__flex">
                        <div class="p-card__third">
                            <div class="p-card__body">
                                <div class="p-card-title">
                                  <p>
                                    直感的に使えまっせ的なフレーズ
                                  </p>
                                </div>
                                <div class="p-card-content__third">
                                  <p>
                                    サンプルアプリです。サンプルアプリです。サンプルアプリです。サンプルアプリです。サンプルアプリです。
                                  </p>
                                </div>
                            </div>
                        </div>
                        <div class="p-card__third">
                            <img src="https://placehold.jp/550x350.png" alt="" class="p-card-img__third">
                        </div>
                    </div>
                </div>
              </section>
              <section class="l-section l-section__fourth">
                <div class="u-inner">
                  
                </div>
              </section>

        </div><!-- l-wrapper__top -->
        <Footer/>
</div>
</template>

<script>
  import Header from './header'
  import Footer from './footer'
export default {
  components: {
    Header,
    Footer
  }
}
</script>

<style>

</style>