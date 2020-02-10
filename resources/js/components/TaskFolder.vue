<template>
  <div>
    <div class="c-task--sidebar">
      <FolderProfile/>
      <hr class="u-task-line">
      <FolderAdd/>
      <div class="c-task--sidebar__wrapp c-task--folder">
        <div class="c-task--folder__wrapp">
          <i class="fas fa-bars c-task--folder__item"></i>
          <label for="">フォルダタイトル</label>
        </div>
      </div>
      <!-- c-task--sidebar__wrapp -->
    </div>
    <!-- c-task--sidebar -->
    <!-- TODOコンポーネント  -->
  </div>
</template>
<script>
import FolderProfile from './FolderProfile'
import FolderAdd from './FolderAdd'
export default {
  data(){
    return {

    }
  },
  components: {
    FolderProfile,
    FolderAdd
  },
  computed: {

  },
  methods: {
    
  
  }
}
</script>
<style>

</style>