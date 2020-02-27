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
                                    <draggable :list="FolderLists" tag="ul" v-bind="{animation:300, delay: 50}" handle='.hand-icon'>
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
  import draggable from 'vuedraggable'
  import Header from './Header'
  import TaskFolderProfile from './TaskFolderProfile'
  import TaskFolderAdd from './TaskFolderAdd'
  import TaskFolder from './TaskFolder'
  import TaskCard from './TaskCard'
  import TaskCardAdd from './TaskCardAdd'
  import Message from './Message'
  import { mapState } from 'vuex'

export default {
  data(){
    return{

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
    FolderLists: {
        get(){
          return this.$store.state.taskStore.FolderLists
        },
        set(value){
          console.log(value)
          this.$store.commit('taskStore/setFolderLists', value)
        }
      },
    CardLists: {
      get(){
        return this.$store.state.taskStore.CardLists
      },
        set(value){
        console.log(value)
        this.$store.commit('taskStore/setFolderLists', value)
      }
    }
    // ...mapState("taskStore",['FolderLists'])
  },
  methods:{
    async setFolderLists(data){
      await this.$store.dispatch('taskStore/setFolderLists', data)
    },
    async getFolderLists(){
      await axios.get('/api/folder').then( response => {
      var data = []
      var datas = response.data.folders
      for(var key in datas){
        data.push(datas[key])
      }
      this.setFolderLists(data)
      }).catch( error => {
        console.log(error)
      })
    }
  },
  created(){
    this.getFolderLists()
  }
}
</script>
<style>
.c-task--cardbtn--inner{
 margin: 10px; 
}


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