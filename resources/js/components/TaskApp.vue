<template>
    <div>
        <Header/>
        <div class="c-task">
            <div class="c-task--content">
                <div class="c-task--borad01">
                    <div class="c-task--borad02">
                        <div class="c-task--borad03">
                            <div class="c-task--sidebar">
                                <TaskFolderProfile/>
                                <hr class="u-task-line">
                                <TaskFolderAdd :list="FolderLists"/>
                                <div class="c-task--sidebar__wrapp c-task--folder">
                                    <draggable :list="FolderLists" tag="ul" v-bind="{animation:300, delay: 50}" handle='.hand-icon' @change='onChange'>
                                        <TaskFolder v-for="(folders, index) in FolderLists" :key="folders.id" :id="folders.id" :listIndex="index" :title = "folders.title"/>
                                    </draggable>
                                </div>
                                <!-- end c-task--sidebar__wrapp -->
                            </div>
                            <!-- end c-task--sidebar -->

                            <!-- TODOコンポーネント  -->
                            <div class="c-task--card">
                                <TaskCard v-for="(cards, index) in CardLists" :key="cards.id" :id="cards.id" :listIndex="index" :cards="cards"/>
                            </div>
                            <TaskCardAdd/>
                        </div>
                        <!-- end c-task--borad03 -->
                    </div>
                    <!-- end c-task--borad02 -->
                </div>
                <!-- end c-task--borad01 -->
            </div>
            <!-- end c-task-content -->
        </div>
    </div>
</template>
<script>
  import draggable from 'vuedraggable';
  import Header from './Header';
  import TaskFolderProfile from './TaskFolderProfile';
  import TaskFolderAdd from './TaskFolderAdd';
  import TaskFolder from './TaskFolder';
  import TaskCard from './TaskCard';
  import TaskCardAdd from './TaskCardAdd';
  import Message from './Message';
  import { mapState, mapGetters } from 'vuex';

export default {
  data(){
    return{
      // folderData: ''
    }
  },
  components:{
    Header,
    TaskFolderProfile,
    TaskFolderAdd,
    TaskFolder,
    TaskCard,
    TaskCardAdd,
    draggable,
    Message
  },
  computed:{
    // taskStore.jsのステート：FolderListsを常に参照している
    ...mapState({
      FolderLists: state => state.taskStore.FolderLists,
      CardLists: state => state.taskStore.CardLists
    }),
  },
  methods:{
    async setFolderLists(data){
      await this.$store.dispatch('taskStore/setFolderLists', data);
    },
    async getFolderLists(){
      await axios.get('/api/folder').then( response => {
      var data = response.data.folders;
      // this.folderData = data
      this.setFolderLists(data);
      }).catch( error => {
        console.log(error);
      })
    },
    async updateFolderSort(newFolders){
      await this.$store.dispatch('taskStore/updateFolderSort', newFolders);
    },
    onChange(){
      // let newFolders = this.folderData.map((folder, index) => {
      let newFolders = this.FolderLists.map((folder, index) => {
        folder.priority = index +1;
        return folder;
      })
      this.updateFolderSort(newFolders);
    }
  },
  // クリエイトライフサイクルフック
  created(){
    this.getFolderLists();
  }
}
</script>
<style>
::-webkit-scrollbar{
  width: 10px;
}
::-webkit-scrollbar-track{
  background: #fff;
  border: none;
  border-radius: 10px;
  box-shadow: inset 0 0 2px #777; 
}
::-webkit-scrollbar-thumb{
  background: #ccc;
  border-radius: 10px;
  box-shadow: none;
}
</style>