<template>
    <div class="msg_cover msg_hide msg_appear" v-if="this.messageData">
        <p>{{ messageData }}</p>
    </div>
    <div class="msg_cover msg_hide msg_appear" v-else>
        <p>更新されました</p>
    </div>
</template>
<script>
export default {
    data(){
        return{

        }
    },
    props:['messageData']
}
</script>>
<style></style>
