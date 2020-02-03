<template>
     <div class="l-side-main">
              <div class="l-side-wrapp l-side-wrapp__taskbox">
                サンプルテキスト
                <div class="c-task">
                  フォルダタイトル
                </div>
                <div>
                  TODOリスト
                </div>
                <div v-if="todo_flag">
                  <i class="fas fa-plus"></i>
                  <label for="">新しいタスクを追加</label>
                </div>
                <div v-else>
                  <input type="text" >
                </div>
              </div>
      </div>
</template>

<script>
export default {

}
</script>

<style>

</style>