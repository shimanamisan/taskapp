window._ = require("lodash");

/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {
    window.Popper = require("popper.js").default;
    window.$ = window.jQuery = require("jquery");

    require("bootstrap");
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

// import { getCookieValue } from './csrf'

window.axios = require("axios");

// POST時に、VerifyCsrfTokenミドルウェアがX-CSRF-TOKENリクエストヘッダもチェックします
// https://readouble.com/laravel/5.8/ja/csrf.html#csrf-x-xsrf-token
// Ajaxリクエストであることを示すヘッダーを付与する
// ここをコメントアウトすると419エラーが出る（csrf用のトークンが無い）
window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

// interceptorsを使用することでエラーのレスポンスをまとめる事ができる
window.axios.interceptors.response.use(
    // 成功時のレスポンスはそのまま使う
    (response) => response,
    // エラー時のレスポンスはエラーメッセージそのものではなく、レスポンスオブジェクトを返すと言う処理が
    // どのAPI呼び出し時でも共通だったので、インターセプターにまとめる
    (error) => error.response || error
);