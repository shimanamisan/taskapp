<template>
    <div>
        <Header/>
        <div class="c-task">
            <div class="c-task--content">
                <div class="c-task--borad01">
                    <div class="c-task--borad02">
                        <div class="c-task--borad03">
                          <TaskFolder

                          
                          />
                          <TaskList
                          
                          
                          
                          />
                        </div><!-- c-task--borad03 -->
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
  import TaskFolder from './TaskFolder'
  import TaskList from './TaskList'
  import Message from './Message'
  import { mapState } from 'vuex'

export default {
  data(){
    return{

    }
  },
  components:{
    Header,
    TaskFolder,
    TaskList,
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
    GetAllLists(){
      axios.get('/api/folder').then( response => {
        this.setAlllists(response.data)
      }).catch( error => {
        console.log(error)
      })
    }
  },
  created(){
    this.GetAllLists()
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