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

                                    <draggable :list="AllLists" tag="ul" :options="{animation:300, handle:'.hand-icon'}" >
                                        <TaskFolder
                                        v-for="folder in AllLists"
                                        :key="folder.id"
                                        :title="folder.title"/>                               
                                    </draggable>

                                </div>
                                <!-- c-task--sidebar__wrapp -->
                            </div>
                            <!-- c-task--sidebar -->
                            <!-- TODOコンポーネント  -->
                            
                              <div class="c-task--card" v-for="(folders, index) in AllLists"
                                  :key="index">
                        
                                  <TaskCard v-for="(cards, index) in folders.cards"
                                  :key="index"
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
    // taskStore.jsのステート：AllListsを常に参照している
    ...mapState("taskStore",['AllLists'])
  },
  methods:{
    async setAlllists(data){
      await this.$store.dispatch('taskStore/setAllLists', data)
    },
    async getAllLists(){
      await axios.get('/api/folder').then( response => {
      let datas = response.data
      this.setAlllists(datas.folders)
      }).catch( error => {
        console.log(error)
      })
    },

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