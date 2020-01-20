// レスポンスコードを元に、どの様なエラーか判断する
// アプリケーション的に意味のある数字がハードコードされるのを避けるためにステータスコードの定義を追加
export const OK = 200
export const CREATED = 201
export const INTERNAL_SERVER_ERROR = 500
export const UNPROCESSABLE_ENTITY = 422