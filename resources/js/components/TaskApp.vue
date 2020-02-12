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
                                <TaskFolderAdd/>
                                <div class="c-task--sidebar__wrapp c-task--folder">
                                  <ul>
                                      <TaskFolder v-for="folderItem in AllLists.folders" :key="folderItem.id" :title="folderItem.title" />                               

                                  </ul>
                                </div>
                                <!-- c-task--sidebar__wrapp -->
                            </div>
                            <!-- c-task--sidebar -->
                            <!-- TODOコンポーネント  -->
                            <div class="c-task--card">
                            <TaskCard v-for="cards in AllLists.folders"
                            :key="cards.id"
                            :cards="cards"
                            />
                             </div>
                            <TaskCardAdd/>
                        </div>
                        <!-- c-task--borad03 -->
                    </div>
                    <!-- c-task--borad02 -->
                </div>
                <!-- c-task--borad01 -->
            </div>
            <!-- c-task-content -->
        </div>
    </div>
</template>
<script>
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
    Message
  },
  computed:{
    // taskStore.jsのステート：AllListsを常に参照している
    ...mapState("taskStore",['AllLists'])
  },
  methods:{
    async setAlllists(data){
      await this.$store.dispatch('taskStore/alllists', data)
    },
    getAllLists(){
      axios.get('/api/folder').then( response => {
        // console.log(response.data)
        this.setAlllists(response.data)
      }).catch( error => {
        console.log(error)
      })
    }
  },
  created(){
    this.getAllLists()
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