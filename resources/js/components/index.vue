<template>
  <div>
    <Header />
    <div class="l-wrapper__top">
      <section class="l-section__first">
        <div class="p-eyecatch">
          <div class="p-eyecatch__inner">
            <div class="p-eyecatch__layout">
              <div class="p-eyecatch__flex u-ind-wrapp__sub">
                <div class="c-logo__header c-logo__clear-margin">
                  <img :src="this.eyecatch_logo" alt="logo" class="c-logo__top" />
                  <h1 class="p-eyecatch__title">
                    簡単な操作で軽快に
                    <br />タスクをこなそう
                  </h1>
                </div>
                <div>
                  <img :src="this.eyecatch" alt="アイキャッチ画像" class="p-eyecatch__img" />
                </div>
              </div>
            </div>
          </div>
          <!-- p-eyecatch--inner -->
        </div>
      </section>
      <section class="l-section l-section__second">
        <div class="u-inner--index">
          <h2 class="u-title p-title">こんなことでお悩みではないですか？</h2>
          <div class="l-section-wrapp l-section-wrapp__flex">
            <div class="p-card p-card-border">
              <img :src="this.panel_first" alt="課題1" />
              <div class="p-card-content">
                <p>機能が多すぎて使い方を覚える時間が煩わしい</p>
              </div>
            </div>
            <div class="p-card p-card-border">
              <img :src="this.panel_second" alt="課題2" />
              <div class="p-card-content">
                <p>スマホから使うと動作が重くてストレスを感じる</p>
              </div>
            </div>
            <div class="p-card p-card-border">
              <img :src="this.panel_third" alt="課題3" />
              <div class="p-card-content">
                <p>簡素な機能でもっと直感的に扱うアプリが欲しい</p>
              </div>
            </div>
          </div>
        </div>
      </section>
      <section class="l-section l-section__third">
        <div class="u-inner--index">
          <div class="l-section-wrapp l-section-wrapp__flex">
            <div class="p-card__third u-inner--index">
              <div class="p-card__body">
                <div class="p-card-title">
                  <p class="p-title">タスクの整理が簡単に行えます！</p>
                </div>
                <div class="p-card-content__third u-inner__l">
                  <p class="p-eyecatch--p">
                    難しい操作は必要ありません。自由にタスクを追加・移動しタスクを管理するだけです！
                    <br />TaskAppでは直感的な操作で完結できるので、専門知識がなくても使いやすいシンプルな機能、デザインです。
                  </p>
                </div>
              </div>
            </div>
            <div class="p-card__third">
              <img :src="this.top_gif" alt class="p-card-img__third" />
            </div>
          </div>
        </div>
      </section>
      <section class="l-section l-section__fourth">
        <div class="u-inner--index">
          <div class="l-section-wrapp l-section-wrapp__flex">
            <div class="p-card__third u-inner--index">
              <div class="p-card__body">
                <div class="p-card-content__third u-inner__l">
                  <div class="p-card-title">
                    <p class="p-title">
                      TaskAppは個人で
                      <br />気軽に使えるタスク管理アプリです
                    </p>
                  </div>
                  <p class="p-eyecatch--p">
                    仕事や家の用事など、生活スタイルに合わせて使うことが出来ます。
                    TaskAppを使用して、効率よく日々のタスクをこなしましょう！
                  </p>
                </div>
              </div>
            </div>
            <div class="p-card__third u-inner--index u-icon--wrapp">
              <router-link
                tag="button"
                to="login"
                class="p-card__third--right c-btn c-btn__footer c-btn__footer--login"
              >ログイン</router-link>
              <router-link to="/contact">
                <button class="p-card__third--right c-btn c-btn__footer c-btn__footer--message">
                  <i class="far fa-envelope u-icon u-icon__message"></i>お問い合わせ
                </button>
              </router-link>
              <i class="fab fa-twitter u-icon u-icon__sns"></i>
              <i class="fab fa-facebook u-icon u-icon__sns"></i>
              <i class="fab fa-instagram u-icon u-icon__sns"></i>
            </div>
          </div>
        </div>
      </section>
    </div>
    <!-- l-wrapper__top -->
    <Footer />
  </div>
</template>
<script>
import eyecatch_logo from "../../img/eyecatch-logo.png"
import eyecatch from "../../img/eyecatch-img.png"
import panel_first from "../../img/top-panels_01.png"
import panel_second from "../../img/top-panels_02.png"
import panel_third from "../../img/top-panels_03.png"
import top_gif from "../../img/animation.gif"
import Header from "./Header";
import Footer from "./footer";
export default {
  data() {
    return {
      eyecatch_logo: eyecatch_logo,
      eyecatch: eyecatch,
      panel_first: panel_first,
      panel_second: panel_second,
      panel_third: panel_third,
      top_gif: top_gif
    };
  },
  components: {
    Header,
    Footer
  }
};
</script>
<style>
</style>