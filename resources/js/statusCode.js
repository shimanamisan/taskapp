// レスポンスコードを元に、どの様なエラーか判断する
// アプリケーション的に意味のある数字がハードコードされるのを避けるためにステータスコードの定義を追加
export const OK = 200
export const CREATED = 201
export const INTERNAL_SERVER_ERROR = 500

// 4xxはクライアントエラー（クライアントからのリクエストが成功しなかった場合に返される）
export const UNPROCESSABLE_ENTITY = 422 // リクエスト情報が正しいものの、処理できなかった場合に返答されるステータスコードである。
// 認証切れのレスポンスコード
export const UNAUTHORIZED = 419
// ページが見つからないとき
export const NOT_FOUND = 404