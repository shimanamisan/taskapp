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

                                    <draggable :list="AllLists" tag="ul" v-bind="{animation:300}">

                                        <TaskFolder
                                        v-for = "(folders, index) in AllLists"
                                        :key = "folders.id"
                                        :id = "folders.id"
                                        :listIndex = "index"
                                        :title = "folders.title"/>

                                    </draggable>

                                </div>
                                <!-- c-task--sidebar__wrapp -->
                            </div>
                            <!-- c-task--sidebar -->
                            <!-- TODOコンポーネント  -->
                            
                            <!-- <draggable group="cards" class="c-task--card"  v-for="(folders, index) in AllLists" :key="index"> -->
                              <div class="c-task--card" v-for="(folders, index) in AllLists" :list="folders"
                              :key="folders.id"
                              :listIndex = "index"
                              >
                                 
                                  <TaskCard v-for="(cards, index) in folders.cards" 
                                  :key = "cards.id"
                                  :id = "cards.id"
                                  :listIndex = "index"
                                  :cards = "cards"
                                  />
                              <!-- </draggable> -->
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
    AllLists: {
        get(){
          return this.$store.state.taskStore.AllLists
        },
        set(value){
          console.log(value)
          this.$store.commit('taskStore/setAllLists', value)
        }
      }
    // ...mapState("taskStore",['AllLists'])
  },
  methods:{
    async setAlllists(data){
      await this.$store.dispatch('taskStore/setAllLists', data)
    },
    async getAllLists(){
      await axios.get('/api/folder').then( response => {
      var data = []
      var datas = response.data.folders
      for(var key in datas){
        data.push(datas[key])
      }
      // 配列に追加できているか確認
      console.log(data)
      // return false
      this.setAlllists(data)
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