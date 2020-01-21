<template>
<div>
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>


</div>
</template>

<script>
import { INTERNAL_SERVER_ERROR } from './statusCode'

export default {
  computed: {
    errorCode(){
      return this.$store.state.error.code
    }
  },
  // ストアのステートを算出プロパティで参照し、それをウォッチャーで監視する
  watch: {
    errorCode: {
      handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        }
      },
      immediate: true
    },
    $route() {
      this.$store.commit('error/setCode', null)
    }
  }
}
</script>

<style scoped>
.fade-enter,
.fade-leave-to {
  opacity: 0;
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

</style>